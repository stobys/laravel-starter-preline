import './bootstrap';

// -- PreLine
import 'preline';

// -- Flatpickr
import flatpickr from 'flatpickr';
import { Polish } from 'flatpickr/dist/l10n/pl.js';
window.flatpickr = flatpickr;

document.addEventListener('DOMContentLoaded', () => {
    // Preline
    window.HSStaticMethods.autoInit();

    // Flatpickr — auto-init wszystkich inputów z data-datepicker
    document.querySelectorAll('[data-datepicker]').forEach(el => {
        flatpickr(el, {
            locale: Polish,
            dateFormat: 'Y-m-d',
			weekNumbers: true,
			// onReady: function(selectedDates, dateStr, instance) {
			// 		const cal = instance.calendarContainer;
			// 		const nav = instance.monthNav;
			// 		const next = instance.nextMonthNav;
			// 		const prev = instance.prevMonthNav;
			// 		const days = instance.daysContainer;

			// 		// Kontener kalendarza
			// 		cal.className = `${cal.className} !bg-white !border !border-gray-200 !rounded-xl !shadow-lg !p-4 !font-sans`;

			// 		// Nawigacja miesięcy
			// 		nav.className = `${nav.className} flex items-center justify-between mb-3`;

			// 		// Strzałki
			// 		next.className = `${next.className} !bg-transparent hover:!bg-gray-100 !rounded-lg !p-1 transition-colors`;
			// 		prev.className = `${prev.className} !bg-transparent hover:!bg-gray-100 !rounded-lg !p-1 transition-colors`;

			// 		// Dni — zaznaczone i hover
			// 		days.className = `${days.className}
			// 			[&_.flatpickr-day]:!rounded-lg
			// 			[&_.flatpickr-day:hover]:!bg-gray-100
			// 			[&_.flatpickr-day.selected]:!bg-primary
			// 			[&_.flatpickr-day.selected]:!border-primary
			// 			[&_.flatpickr-day.today]:!border-primary
			// 		`;
			// 	}
        });
    });

    // Flatpickr — auto-init wszystkich inputów z data-datetimepicker
    document.querySelectorAll('[data-datetimepicker]').forEach(el => {
        flatpickr(el, {
            locale: Polish,
			enableTime: true,
    		dateFormat: "Y-m-d H:i",
			weekNumbers: true,
			// onReady: function(selectedDates, dateStr, instance) {
			// 		const cal = instance.calendarContainer;
			// 		const nav = instance.monthNav;
			// 		const next = instance.nextMonthNav;
			// 		const prev = instance.prevMonthNav;
			// 		const days = instance.daysContainer;

			// 		// Kontener kalendarza
			// 		cal.className = `${cal.className} !bg-white !border !border-gray-200 !rounded-xl !shadow-lg !p-4 !font-sans`;

			// 		// Nawigacja miesięcy
			// 		nav.className = `${nav.className} flex items-center justify-between mb-3`;

			// 		// Strzałki
			// 		next.className = `${next.className} !bg-transparent hover:!bg-gray-100 !rounded-lg !p-1 transition-colors`;
			// 		prev.className = `${prev.className} !bg-transparent hover:!bg-gray-100 !rounded-lg !p-1 transition-colors`;

			// 		// Dni — zaznaczone i hover
			// 		days.className = `${days.className}
			// 			[&_.flatpickr-day]:!rounded-lg
			// 			[&_.flatpickr-day:hover]:!bg-gray-100
			// 			[&_.flatpickr-day.selected]:!bg-primary
			// 			[&_.flatpickr-day.selected]:!border-primary
			// 			[&_.flatpickr-day.today]:!border-primary
			// 		`;
			// 	}
        });
    });
});

// -- AlpineJS
// import Alpine from 'alpinejs'
// window.Alpine = Alpine

// document.addEventListener('DOMContentLoaded', () => {
// 	Alpine.start()
// });


// resources/js/app.js
// import mask from '@alpinejs/mask'

// document.addEventListener('alpine:init', () => {
//     Alpine.plugin(mask)
// })
