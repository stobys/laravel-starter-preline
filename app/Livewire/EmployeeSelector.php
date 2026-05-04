<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EmployeeSelector extends Component
{
    // All available employees
    public $allEmployees = [];
    
    // Available (left side) and selected (right side) employee IDs
    public $availableEmployees = [];
    public $selectedEmployees = [];
    
    // Selected items in each list
    public $availableSelected = [];
    public $selectedSelected = [];
    
    // Filters
    public $departmentFilter = '';
    public $nameFilter = '';
    
    // Available departments
    public $departments = [];

    public function mount()
    {
        $this->allEmployees = User::query()->nonSystemOnly()
            ->select([
                'users.id as id',
                'users.full_name as name',
                'departments.abbr as department',
            ])
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            // ->leftJoin('users as managers', 'managers.id', '=', 'users.manager_id')
            ->get()->toArray();

        // Extract unique departments
        $this->departments = collect($this->allEmployees)
            ->pluck('department')
            ->unique()
            ->sort()
            ->values()
            ->toArray();
        
        // Initially all employees are available
        $this->availableEmployees = collect($this->allEmployees)->pluck('id')->toArray();
    }

    public function getFilteredAvailableEmployeesProperty()
    {
        $availableEmployees = collect($this->allEmployees)
            ->filter(fn($emp) => in_array($emp['id'], $this->availableEmployees))
            ->when($this->departmentFilter, fn($collection) => 
                $collection->filter(fn($emp) => $emp['department'] === $this->departmentFilter)
            )
            ->when($this->nameFilter, fn($collection) => 
                $collection->filter(fn($emp) => 
                    stripos($emp['name'], $this->nameFilter) !== false
                )
            )
            ->values()
            ->toArray();

        // dd($availableEmployees);
        return $availableEmployees;
    }

    public function getSelectedEmployeesListProperty()
    {
        return collect($this->allEmployees)
            ->filter(fn($emp) => in_array($emp['id'], $this->selectedEmployees))
            ->values()
            ->toArray();
    }

    public function moveSelected()
    {
        if (empty($this->availableSelected)) {
            return;
        }

        // Move selected items from available to selected
        $this->selectedEmployees = array_merge(
            $this->selectedEmployees,
            $this->availableSelected
        );
        
        $this->availableEmployees = array_diff(
            $this->availableEmployees,
            $this->availableSelected
        );
        
        $this->availableSelected = [];
    }

    public function moveAll()
    {
        // Get all filtered available employees
        $filtered = $this->filteredAvailableEmployees;
        $idsToMove = collect($filtered)->pluck('id')->toArray();
        
        if (empty($idsToMove)) {
            return;
        }

        // Move all filtered items
        $this->selectedEmployees = array_merge(
            $this->selectedEmployees,
            $idsToMove
        );
        
        $this->availableEmployees = array_diff(
            $this->availableEmployees,
            $idsToMove
        );
        
        $this->availableSelected = [];
    }

    public function removeSelected()
    {
        if (empty($this->selectedSelected)) {
            return;
        }

        // Move selected items back to available
        $this->availableEmployees = array_merge(
            $this->availableEmployees,
            $this->selectedSelected
        );
        
        $this->selectedEmployees = array_diff(
            $this->selectedEmployees,
            $this->selectedSelected
        );
        
        $this->selectedSelected = [];
    }

    public function removeAll()
    {
        if (empty($this->selectedEmployees)) {
            return;
        }

        // Move all selected items back to available
        $this->availableEmployees = array_merge(
            $this->availableEmployees,
            $this->selectedEmployees
        );
        
        $this->selectedEmployees = [];
        $this->selectedSelected = [];
    }

    public function render()
    {
        return view('livewire.employee-selector');
    }
}
