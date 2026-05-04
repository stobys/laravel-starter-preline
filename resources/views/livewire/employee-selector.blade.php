<div>
    <div class="w-full max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr_auto_1fr] gap-6 items-start">
            <div class="flex flex-col gap-3 lg:self-start pt-6">
                <!-- Department Filter -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Filter by Department
                    </label>
                    <select wire:model.live="departmentFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Name Filter -->
                <div  class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Filter by Name
                    </label>
                    <input type="text" wire:model.live.debounce.500ms="nameFilter"
                        placeholder="Type name..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>

            <!-- Left Side: Available Employees -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Available Employees</h3>

                <!-- Available Employees List -->
                <div class="border border-gray-300 rounded-md">
                    <select size="12" multiple wire:model.live="availableSelected"
                        class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"
                    >
                        @forelse($this->filteredAvailableEmployees as $employee)
                            <option value="{{ $employee['id'] }}" class="py-1.5 cursor-pointer hover:bg-blue-50">
                                {{ $employee['name'] }} ({{ $employee['department'] }})
                            </option>
                        @empty
                            <option disabled class="text-gray-500 italic">No employees found</option>
                        @endforelse
                    </select>
                </div>

                <p class="text-xs text-gray-600">
                    Showing {{ count($this->filteredAvailableEmployees) }} of {{ count($availableEmployees) }} available employees
                </p>
            </div>

            <!-- Middle: Transfer Buttons -->
            <div class="flex flex-col gap-3 lg:self-center">
                <!-- Move Selected to Right -->
                <button type="button" wire:click="moveSelected"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    @disabled(empty($availableSelected))
                >
                    <span class="inline-flex items-center gap-2">
                        <span>Add Selected</span>
                        @svg('feather-chevron-right', 'w-5 h-5')
                    </span>
                </button>

                <!-- Move All to Right -->
                <button type="button" wire:click="moveAll"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    @disabled(empty($this->filteredAvailableEmployees))
                >
                    <span class="inline-flex items-center gap-2">
                        <span>Add All</span>
                        @svg('feather-chevrons-right', 'w-5 h-5')
                    </span>
                </button>

                <div class="border-t border-gray-300 my-2"></div>

                <!-- Remove Selected from Right -->
                <button type="button" wire:click="removeSelected"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    @disabled(empty($selectedSelected))
                >
                    <span class="inline-flex items-center gap-2">
                        @svg('feather-chevron-left', 'w-5 h-5')
                        <span>Remove Selected</span>
                    </span>
                </button>

                <!-- Remove All from Right -->
                <button type="button" wire:click="removeAll"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    @disabled(empty($selectedEmployees))
                >
                    <span class="inline-flex items-center gap-2">
                        @svg('feather-chevrons-left', 'w-5 h-5')
                        <span>Remove All</span>
                    </span>
                </button>
            </div>

            <!-- Right Side: Selected Employees -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Selected Employees</h3>

                <!-- Selected Employees List -->
                <div class="border border-gray-300 rounded-md">
                    <select size="12" multiple wire:model.live="selectedSelected"
                        class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"
                    >
                        @forelse($this->selectedEmployeesList as $employee)
                            <option value="{{ $employee['id'] }}" class="py-1.5 cursor-pointer hover:bg-blue-50">
                                {{ $employee['name'] }} ({{ $employee['department'] }})
                            </option>
                        @empty
                            <option disabled class="text-gray-500 italic">No employees selected</option>
                        @endforelse
                    </select>
                    <select name="employees" multiple hidden="hidden">
                        @forelse($this->selectedEmployeesList as $employee)
                            <option  @selected(true) value="{{ $employee['id'] }}">
                                {{ $employee['name'] }} ({{ $employee['department'] }})
                            </option>
                        @empty
                            <option disabled class="text-gray-500 italic">No employees selected</option>
                        @endforelse
                    </select>
                </div>

                @error('employees')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                <p class="text-xs text-gray-600">
                    {{ count($selectedEmployees) }} employee(s) selected
                </p>
            </div>

        </div>
    </div>

    <style>
        /* Remove default select styling and allow custom styling */
        select[multiple] {
            background-color: white;
        }

        select[multiple] option {
            padding: 0.375rem 0.5rem;
        }

        select[multiple] option:checked {
            background: linear-gradient(#3b82f6, #3b82f6);
            color: white;
        }

        /* Firefox */
        @-moz-document url-prefix() {
            select[multiple] option:checked {
                background-color: #3b82f6;
            }
        }
    </style>
</div>
