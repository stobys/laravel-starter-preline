@extends('layout.flowbite.app')

@section('content')
    <livewire:department-component />
@endsection

@section('drawers')
    {{-- @includeIf('departments.partials.create-drawer') --}}
    {{-- @includeIf('departments.partials.preview-drawer') --}}
@endsection

@push('scripts')
    <script>
        function showPreviewDrawer() {
            console.log('showPreviewDrawer');
            // window.livewire.emit('openPreviewDrawer', training_id);
            const $targetEl = document.getElementById('department-preview-drawer');
            const drawer = new Drawer($targetEl);
            drawer.show();
        }

        function hidePreviewDrawer() {
            console.log('hidePreviewDrawer');
            // window.livewire.emit('openPreviewDrawer', training_id);
            const $targetEl = document.getElementById('department-preview-drawer');
            const drawer = new Drawer($targetEl);
            drawer.hide();
        }

        // function showPreviewDrawer() {
        //     // window.livewire.emit('openPreviewDrawer', training_id);
        //     const $targetEl = document.getElementById('department-preview-drawer');
        //     const drawer = new Drawer($targetEl);
        //     drawer.show();
        // }

        // function hidePreviewDrawer() {
        //     // window.livewire.emit('openPreviewDrawer', training_id);
        //     const $targetEl = document.getElementById('department-preview-drawer');
        //     const drawer = new Drawer($targetEl);
        //     drawer.hide();
        // }

        // function setActiveTab(tab) {
        //     window.livewire.set('activeTab', tab);
        //     // Update URL without page reload
        //     const url = new URL(window.location);
        //     url.searchParams.set('activeTab', tab);
        //     window.history.pushState({}, '', url);
        // }

        // Initialize active tab from URL
        document.addEventListener('livewire:initialized', () => {
            // window.addEventListener('open-modal', event => {
            //     // Znajdź przycisk pierwszej karty i symuluj kliknięcie
            //     const firstTab = document.getElementById('role-general-tab');
            //     if (firstTab) {
            //         firstTab.click();
            //     }
            // });

            // const urlParams = new URLSearchParams(window.location.search);
            // const activeTab = urlParams.get('activeTab');
            // if (activeTab) {
            //     window.livewire.set('activeTab', activeTab);
            // }
        });

        document.addEventListener('DOMContentLoaded', () => {

        });

    </script>
@endpush
