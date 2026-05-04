<?php

namespace App\Models\TETA;

use App\Enums\TETAEmployeeGroup;
use App\Models\Department;
use App\Models\GenericModel as Model;
use App\Models\User;
use App\Traits\ReadOnlyModelTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TetaEmployee extends Model
{
    use ReadOnlyModelTrait;

    // -- The database connection used by the model
    protected $connection = 'oracle';

    // -- The database table used by the model
    protected $table = 't_prac';

    protected $primaryKey = 'prac_id';

    public function newQuery()
    {
        $query = parent::newQuery();

		return $query->select([
				't_prac.prac_id', 't_prac.guid', 't_prac.imie', 't_prac.nazwisko', 't_prac.nr_ew',
				't_prac.data_zatr', 't_prac.data_rozw',
				// 'kp_info_dodatkowe_wartosci.wartosc',
				// 'd_cre', 'd_mod',
				DB::raw('kp_info_dodatkowe_wartosci.wartosc as grupa'),
				DB::raw('akt_dane.mpk_kod(t_prac.prac_id, sysdate) as mpk_code'),
			])
			-> leftJoin('kp_info_dodatkowe_prac', 't_prac.prac_id', '=', 'kp_info_dodatkowe_prac.prac_id')
			-> leftJoin('kp_info_dodatkowe_wartosci', 'kp_info_dodatkowe_wartosci.id', '=', 'kp_info_dodatkowe_prac.indw_id_1')
			-> whereFirmId(100); // only adient internal
    }

    public function sync()
    {
        // T_PRAC: prac_id, imie, imie_2, nazwisko, nr_ew, data_zatr, data_rozw, guid
        $model = [
            // 'prac_id'       => $this -> id,
            // 'given_name'    => trim(implode(' ', [$this -> imie, $this -> imie_2])),
            'first_name'    	=> mb_ucfirst(mb_strtolower($this -> imie)),
            'last_name'   		=> mb_ucfirst(mb_strtolower($this -> nazwisko)),
            // 'company_id'    => $this -> firm_id,
            'personal_id'   => $this -> nr_ew,
			'department_id'	=> Department::where('teta_mpk_code', $this->mpk_code)->value('id'),
            // 'created_at'    => $this -> d_cre,
            // 'updated_at'    => $this -> d_mod,
            'hired_at'      => $this -> data_zatr,
            'dismissed_at'  => $this -> data_rozw,
            'teta_guid'     => $this -> guid,
            'teta_prac_id'  => $this -> prac_id,
			'teta_grupa'	=> TETAEmployeeGroup::fromName($this -> grupa ?? 'U')->value ?? null,
			'mpk_code'		=> $this -> mpk_code,
        ];

		$user = User::where('teta_prac_id', $model['teta_prac_id'])->first();
		if( $user )
		{
			$user->update($model);
		}
		else {
			User::updateOrCreate([
				'first_name' => $model['first_name'],
				'last_name' => $model['last_name'],
			], $model);
		}
    }

    public function scopePracId($query, $prac_id = null)
    {
        if (! empty($prac_id)) {
            $query -> where('prac_id', '=', $prac_id);
        }

        return $query;
    }

    public static function fetch($employees)
    {
        $employees = array_wrap($employees);

        $collection = TetaEmployee::select(
                        [
                            'prac_id', 'nr_ew', 'guid',
                            'imie', 'imie_2', 'nazwisko', 'plec', 'data_zatr', 'data_rozw',
                            DB::raw('AKT_DANE.STANOWISKO(T_PRAC.PRAC_ID, CURRENT_DATE) as STANOWISKO'),
                            DB::raw('AKT_DANE.MPK_KOD(T_PRAC.PRAC_ID, CURRENT_DATE) as MPK_KOD'),
                        ]
                    )
                        -> whereIn('firm_id', [100,160])
                        -> where(function ($query) use ($employees) {
                            $query -> whereIn('prac_id', $employees)
                                -> orWhereIn('nr_ew', $employees);
                        })
                        -> get();

        foreach ($collection as $model) {
            $model -> sync();
        }
    }

    public function getTetaQuery()
    {
        $dottedYearMonth = $this -> year .'.'. $this -> month;
        $dashedYearMonth = $this -> year .'-'. $this -> month;

        $firstDayOfMonth = Carbon::create($this -> year, $this -> month, 1, 0, 0, 0);
        $lastDayOfMonth = Carbon::create($this -> year, $this -> month, 1, 0, 0, 0) -> endOfMonth();

        $dottedFirstDayOfMonth = $firstDayOfMonth -> format('Y.m.d');
        $dashedFirstDayOfMonth = $firstDayOfMonth -> format('Y-m-d');

        $dottedLastDayOfMonth = $lastDayOfMonth -> format('Y.m.d');
        $dashedLastDayOfMonth = $lastDayOfMonth -> format('Y-m-d');

        $firmId = $this -> firm_id;

        $query = "select
                A.prac_id,
                A.nr_ew,
                A.imie,
                A.nazwisko,
                to_char(A.data_zatr, 'YYYY-MM-DD') as data_zatr,
                to_char(A.data_rozw, 'YYYY-MM-DD') as data_rozw,
                A.stanowisko,
                A.grupa,
                A.mpk_kod,
                A.klasyfikator,
                A.DEL_DNI_ROB,
                A.ABS_R,
                B.CZAS_NORM,
                (B.CZAS_NORM/8) DO_PRZEPRACOWANIA,
                D.drob,
                B.CZAS_POTRACAC,
                case
                    when (B.CZAS_NORM/8) = 0 THEN 0 when A.klasyfikator is null or A.klasyfikator = '' THEN 0 else 1
                end as CZY_PREMIA,
                case
                    when A.klasyfikator is null or A.klasyfikator = '' THEN 0 else (B.CZAS_NORM/8)
                end as DNI_DO_PREMI,
                B.CZAS_SAP2,
                A.NORMA_DZIENNA,
                C.NORMA_STARA,
                C.data_do,
                case
                    when A.ACTUAL_NORM is null then (D.DROB*C.OLD_NORM)
                    else nvl((A.ACTUAL_NORM * D.DROB), B.CZAS_NORM)
                end as FULL_NORM,
                case
                    when A.klasyfikator IN ('wskaz_10', 'wskaz_15', 'wskaz_20') or A.klasyfikator is null and A.GRUPA = 'D' THEN null
                    when A.klasyfikator in ('bonus', 'brak') THEN 'brak'
                    when A.klasyfikator like '%cele%' THEN 'cele' else 'sr'
                end as PREMIA_RODZAJ,
                case
                    when A.klasyfikator like '%cele%' or A.klasyfikator = 'brak' or A.klasyfikator = 'bonus' or A.klasyfikator is null or A.klasyfikator = '' then 0
                    when A.klasyfikator IN ('wskaz_40', 'wskaz_20', 'wskaz_15', 'srednia wskaz_20') then 0.20
                    when A.klasyfikator = 'wskaz_10' then 0.10
                    else 0
                end as PREMIA_MAX
            from (
                select
                    prac_id, imie, nazwisko, data_zatr, nr_ew, data_rozw, firm_id,
                    (select SL_D.wartosc from kp_info_dodatkowe_prac D, kp_info_dodatkowe_wartosci SL_D where SL_D.id = D.indw_id_1 and D.prac_id= prac.prac_id) grupa,
                    NVL(akt_dane.mpk(PRAC.prac_id, to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD')), ost_dane.mpk(PRAC.prac_id)) mpk,
                    NVL(akt_dane.mpk_kod(PRAC.prac_id, to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD')), ost_dane.mpk_kod(PRAC.prac_id)) mpk_kod,
                    NVL(akt_dane.stanowisko(PRAC.prac_id, to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD')), ost_dane.stanowisko(PRAC.prac_id)) stanowisko,
                    (select SL_D.wartosc from kp_info_dodatkowe_prac D, kp_info_dodatkowe_wartosci SL_D where SL_D.id = D.indw_id_2 and D.prac_id = PRAC.prac_id) klasyfikator,
                    to_char(
                        (
                            select SUM(kal.robocze_cnt(L.data_od, L.data_do, L.prac_id, 'D'))
                            from l_absencje L, sl_nieob SL
                            where
                                L.prac_id = PRAC.prac_id
                                and
                                L.nieob_id = SL.id
                                and
                                trunc(L.data_od, 'MM') >= trunc(to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD'), 'MM')
                                and
                                trunc(L.data_od, 'MM') <= trunc(to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD'), 'MM')
                                and
                                SL.kod in ('CHZ', 'ZUS', 'OND', 'ONR', 'OO', 'NN')
                        ), 'fm9999999990.00') ABS_R,
                    to_char(
                        (
                            select SUM(kal.robocze_cnt(L.data_od, L.data_do, L.prac_id, 'D'))
                            from l_absencje L, sl_nieob SL
                            where
                                L.prac_id = PRAC.prac_id
                                and
                                L.nieob_id = SL.id
                                and
                                trunc(L.data_od, 'MM') >= trunc(to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD'), 'MM')
                                and
                                trunc(L.data_od, 'MM') <= trunc(to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD'), 'MM')
                                and
                                SL.kod in ('DEL')
                        ), 'fm9999999990.00') DEL_DNI_ROB,

                    (
                        select

                            case
                                when NOMI.nazwa like '%NIEP%'
                                then (CZAS.norma - 0.50)
                                else
                                    (CZAS.norma - 0.25)
                                end as NORMA_DZIENNA


                        from NT_KP_KDR_GR_CZASU_PRACY CZAS, NT_KP_SLO_GR_CZASU_NOMINAL NOMI
                        where
                            CZAS.SGRC_ID = NOMI.ID
                            and
                            CZAS.prac_id = PRAC.prac_id
                            and
                            (CZAS.data_do is null)

                    ) NORMA_DZIENNA,

                            (
                        select
                            czas.norma as actual_norm
                        from NT_KP_KDR_GR_CZASU_PRACY CZAS, NT_KP_SLO_GR_CZASU_NOMINAL NOMI
                        where
                            CZAS.SGRC_ID = NOMI.ID
                            and
                            CZAS.prac_id = PRAC.prac_id
                            and
                            (CZAS.data_do is null)

                    ) ACTUAL_NORM


                from t_prac prac
                where
                    PRAC.firm_id in (". $firmId .")
					-- and
					-- PRAC.nr_ew in (7895, 7534, 7625, 8604, 1215)
                    and
                    to_char(PRAC.data_zatr, 'YYYY-MM-DD') <= '". $dottedLastDayOfMonth ."'
                ORDER BY PRAC.nazwisko, PRAC.imie, PRAC.nr_ew
            ) A
            inner join
                (
                    select
                        prac_id,
                        SUM(p_rcp_licz.nh_n(k_018)) CZAS_NORM,
                        SUM(p_rcp_licz.nh_n(k_018)) CZAS_PRZEP,
                        SUM(p_rcp_licz.nh_n(k_022)) BILANS,
                        SUM(p_rcp_licz.nh_n(k_046)) CZAS_SAP,
                        SUM(p_rcp_licz.nh_n(k_051)) CZAS_SAP2,
                        SUM(p_rcp_licz.nh_n(k_028)) CZAS_POTRACAC
                    from rcp_bilans
                    where trunc(data, 'MM') = trunc(to_date('". $dottedYearMonth ."'||'.01', 'YYYY/MM/DD'), 'MM') group by prac_id
                ) B
                ON B.prac_id = A.prac_id
            left join
              (
                SELECT sub.id, sub.prac_id, norma_stara, data_do, old_norm
                  FROM (
                  select
                      row_number() over (partition by czas.prac_id order by data_do desc) seq ,
                      czas.id,
                      czas.prac_id,
                      czas.norma as OLD_NORM,
                       case
                                when NOMI.nazwa like '%NIEP%'
                                then (CZAS.norma - 0.50)
                                else
                                    (CZAS.norma - 0.25)
                                end as NORMA_STARA,
                      data_do
                      from NT_KP_KDR_GR_CZASU_PRACY CZAS, NT_KP_SLO_GR_CZASU_NOMINAL NOMI, t_prac
                      where  CZAS.SGRC_ID = NOMI.ID and czas.prac_id = t_prac.prac_id and data_do is not null order by data_do desc  ) sub where seq=1 ) C
              ON A.prac_id = C.prac_id
            left join
              (
                select count(*) as DROB from KP_RCP_EMPL_CALENDAR_DAYS
                where prac_id in (11172) and DAY between to_date('". $dashedFirstDayOfMonth ."', 'YYYY-MM-DD') and to_date('". $dashedLastDayOfMonth ."', 'YYYY-MM-DD') and (DAY_TYPE = 'C' or DAY_TYPE is null)
            ) D
                ON A.prac_id = B.prac_id
        ";

        return $query;
    }

}
