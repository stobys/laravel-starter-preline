        <!-- ===== Sidebar Start ===== -->
        <aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
            class="sidebar fixed left-0 top-0 z-99 flex h-screen w-[290px] flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
        >
            <!-- SIDEBAR HEADER -->
            <div
                :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="flex items-center gap-2 pt-8 sidebar-header pb-7"
            >
                <a href="{{ route('home') }}">
                    <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                        <img class="dark:hidden" style="width:150px;" src="adient/Adient-288.svg.png" alt="Logo" />
                        <img class="hidden dark:block" style="width:150px;" src="adient/Adient-288.svg.png" alt="Logo" />
                    </span>

                    <img src="adient/adient-icon-400.png" class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" alt="Logo" />
                </a>
            </div>
            <!-- SIDEBAR HEADER -->

            <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
                <!-- Sidebar Menu -->
                <nav x-data="{selected: $persist('nothing')}">
                    <!-- Menu Group -->
                    <div>
                        <x-sidebar.label text="menu" />


                        @guest
                        <ul class="flex flex-col gap-4 mb-6">
                            <x-sidebar.item :href="route('login-as')" text="Log In As">
                                <x-slot name="icon">
                                    @svg('feather-log-in', 'w-5 h-5')
                                </x-slot>
                            </x-sidebar.item>

                            <x-sidebar.item :href="route('login')" text="Log In">
                                <x-slot name="icon">
                                    @svg('feather-log-in', 'w-5 h-5')
                                </x-slot>
                            </x-sidebar.item>

                            <x-sidebar.item :href="route('register')" text="Register">
                                <x-slot name="icon">
                                    @svg('feather-user-plus', 'w-5 h-5')
                                </x-slot>
                            </x-sidebar.item>
                        </ul>
                        @endguest

                        @auth
                        <ul class="flex flex-col gap-4 mb-6">
                            {{-- 'ecommerce|analytics|marketing|crm|stocks' --}}

                            <x-sidebar.group text="Access Control" :selected="request()->routeIs('rbac.*')">
                                <x-slot name="icon">
                                    @svg('heroicon-s-squares-2x2', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>

                                <x-sidebar.group :href="route('rbac.roles')" text="Roles" :selected="request()->routeIs('rbac.roles')">
                                    <x-slot name="icon">
                                        @svg('heroicon-o-shield-check', 'w-4 h-4')
                                    </x-slot>
                                </x-sidebar.group>

                                <x-sidebar.group :href="route('rbac.users')" text="Users" :selected="request()->routeIs('rbac.users')">
                                    <x-slot name="icon">
                                        @svg('heroicon-s-users', 'w-4 h-4')
                                    </x-slot>
                                </x-sidebar.group>
                            </x-sidebar.group>

                            <x-sidebar.item text="Calendar" href="calendar.html">
                                <x-slot name="icon">
                                    @svg('heroicon-s-calendar', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>
                            </x-sidebar.item>

                            {{--
                            <x-sidebar.item text="RBAC" :href="route('rbac.index')" :selected="request()->routeIs('rbac.*')">
                                <x-slot name="icon">
                                    @svg('heroicon-s-calendar', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>
                            </x-sidebar.item>
                            --}}

                            <x-sidebar.item text="User Profile" :href="route('profile.edit')" :selected="request()->routeIs('profile.edit')">
                                <x-slot name="icon">
                                    @svg('heroicon-s-user-circle', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>
                            </x-sidebar.item>

                            <x-sidebar.group text="Forms" pages="formElements|formLayout|proFormElements|proFormLayout">
                                <x-slot name="icon">
                                    @svg('heroicon-s-clipboard-document-list', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>

                                <x-sidebar.group href="#" page="formElements" text="Form Elements" />
                            </x-sidebar.group>

                            <x-sidebar.group text="Tables" pages="basicTables|dataTables">
                                <x-slot name="icon">
                                    @svg('heroicon-s-document-duplicate', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>

                                <x-sidebar.group href="#" page="basicTables" text="Basic Tables" />
                                <x-sidebar.group href="#" page="dataTables" text="DataTables" />
                            </x-sidebar.group>

                            <x-sidebar.group text="Pages" pages="fileManager|pricingTables|blank|page404|page500|page503|success|faq|comingSoon|maintenance">
                                <x-slot name="icon">
                                    @svg('heroicon-s-document-duplicate', 'w-6 h-6 menu-item-icon-inactive')
                                </x-slot>

                                <x-sidebar.group href="#" page="blank" text="Blank Page" />
                                <x-sidebar.group href="#" page="page404" text="404 Error" />
                            </x-sidebar.group>
                        </ul>
                        @endauth
                    </div>

                    @auth
                    <!-- Others Group -->
                    <div>
                        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                        <span
                            class="menu-group-title"
                            :class="sidebarToggle ? 'lg:hidden' : ''"
                        >
                            others
                        </span>

                        <svg
                            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                            class="mx-auto fill-current menu-group-icon"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill=""
                            />
                        </svg>
                        </h3>

                        <ul class="flex flex-col gap-4 mb-6">
                        <!-- Menu Item Charts -->
                        <li>
                            <a
                            href="#"
                            @click.prevent="selected = (selected === 'Charts' ? '':'Charts')"
                            class="menu-item group"
                            :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-active' : 'menu-item-inactive'"
                            >
                            <svg
                                :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M12 2C11.5858 2 11.25 2.33579 11.25 2.75V12C11.25 12.4142 11.5858 12.75 12 12.75H21.25C21.6642 12.75 22 12.4142 22 12C22 6.47715 17.5228 2 12 2ZM12.75 11.25V3.53263C13.2645 3.57761 13.7659 3.66843 14.25 3.80098V3.80099C15.6929 4.19606 16.9827 4.96184 18.0104 5.98959C19.0382 7.01734 19.8039 8.30707 20.199 9.75C20.3316 10.2341 20.4224 10.7355 20.4674 11.25H12.75ZM2 12C2 7.25083 5.31065 3.27489 9.75 2.25415V3.80099C6.14748 4.78734 3.5 8.0845 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C15.9155 20.5 19.2127 17.8525 20.199 14.25H21.7459C20.7251 18.6894 16.7492 22 12 22C6.47715 22 2 17.5229 2 12Z"
                                fill=""
                                />
                            </svg>

                            <span
                                class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''"
                            >
                                Charts
                            </span>

                            <svg
                                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Charts') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                                stroke=""
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                />
                            </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div
                            class="overflow-hidden transform translate"
                            :class="(selected === 'Charts') ? 'block' :'hidden'"
                            >
                            <ul
                                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
                            >
                                <x-sidebar.group href="#" page="lineChart" text="Line Chart" />
                                <x-sidebar.group href="#" page="barChart" text="Bar Chart" />
                            </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Charts -->

                        <!-- Menu Item Ui Elements -->
                        <li>
                            <a href="#" class="menu-item group"
                                :class="(selected === 'UIElements') || (page === 'alerts' || page === 'avatars' || page === 'badge' || page === 'buttons' || page === 'buttonsGroup' || page === 'cards'|| page === 'carousel' || page === 'dropdowns' || page === 'images' || page === 'list' || page === 'modals' || page === 'videos') ? 'menu-item-active' : 'menu-item-inactive'"
                                @click.prevent="selected = (selected === 'UIElements' ? '':'UIElements')"
                            >
                            <svg
                                :class="(selected === 'UIElements') || (page === 'alerts' || page === 'avatars' || page === 'badge' || page === 'breadcrumb' || page === 'buttons' || page === 'buttonsGroup' || page === 'cards'|| page === 'carousel' || page === 'dropdowns' || page === 'images' || page === 'list' || page === 'modals' || page === 'notifications' || page === 'popovers' || page === 'progress' || page === 'spinners' || page === 'tooltips' || page === 'videos') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z" fill="" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                UI Elements
                            </span>

                            <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'UIElements') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                                stroke=""
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                />
                            </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div
                            class="overflow-hidden transform translate"
                            :class="(selected === 'UIElements') ? 'block' :'hidden'"
                            >
                            <ul
                                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
                            >
                                <x-sidebar.group href="#" page="alerts" text="Alerts" />
                                <x-sidebar.group href="#" page="avatars" text="Avatars" />
                                <x-sidebar.group href="#" page="badges" text="Badges" />
                                <x-sidebar.group href="#" page="buttons" text="Buttons" />
                                <x-sidebar.group href="#" page="images" text="Images" />
                                <x-sidebar.group href="#" page="videos" text="Videos" />
                            </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Ui Elements -->

                        <!-- Menu Item Authentication -->
                        <li>
                            <a
                            href="#"
                            @click.prevent="selected = (selected === 'Authentication' ? '':'Authentication')"
                            class="menu-item group"
                            :class="(selected === 'Authentication') || (page === 'basicChart' || page === 'advancedChart') ? 'menu-item-active' : 'menu-item-inactive'"
                            >
                            <svg
                                :class="(selected === 'Authentication') || (page === 'basicChart' || page === 'advancedChart') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M14 2.75C14 2.33579 14.3358 2 14.75 2C15.1642 2 15.5 2.33579 15.5 2.75V5.73291L17.75 5.73291H19C19.4142 5.73291 19.75 6.0687 19.75 6.48291C19.75 6.89712 19.4142 7.23291 19 7.23291H18.5L18.5 12.2329C18.5 15.5691 15.9866 18.3183 12.75 18.6901V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V18.6901C8.01342 18.3183 5.5 15.5691 5.5 12.2329L5.5 7.23291H5C4.58579 7.23291 4.25 6.89712 4.25 6.48291C4.25 6.0687 4.58579 5.73291 5 5.73291L6.25 5.73291L8.5 5.73291L8.5 2.75C8.5 2.33579 8.83579 2 9.25 2C9.66421 2 10 2.33579 10 2.75L10 5.73291L14 5.73291V2.75ZM7 7.23291L7 12.2329C7 14.9943 9.23858 17.2329 12 17.2329C14.7614 17.2329 17 14.9943 17 12.2329L17 7.23291L7 7.23291Z"
                                fill=""
                                />
                            </svg>

                            <span
                                class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''"
                            >
                                Authentication
                            </span>

                            <svg
                                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Authentication') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                                stroke=""
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                />
                            </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div
                            class="overflow-hidden transform translate"
                            :class="(selected === 'Authentication') ? 'block' :'hidden'"
                            >
                            <ul
                                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
                            >
                                <x-sidebar.group :href="route('login')" page="signin" text="Log In" />
                                <x-sidebar.group :href="route('register')" page="signup" text="Register" />
                            </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Authentication -->
                        </ul>
                    </div>
                    @endauth
                </nav>
                <!-- Sidebar Menu -->

                {{-- @includeIf('layout.partials.promo-box') --}}
            </div>

            {{--
            <div class="pt-6 my-6 border-t border-stroke dark:border-dark-3 text-gray-500 dark:text-gray-400">
                <div class="flex h-[42px] w-full items-center justify-evenly rounded-md bg-gray-2 dark:bg-dark">
                  <a href="javascript:void(0)" class="text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 3C3.55109 3 3.36032 3.07902 3.21967 3.21967C3.07902 3.36032 3 3.55109 3 3.75V13.9393L4.71967 12.2197C4.86032 12.079 5.05109 12 5.25 12H14.25C14.4489 12 14.6397 11.921 14.7803 11.7803C14.921 11.6397 15 11.4489 15 11.25V3.75C15 3.55109 14.921 3.36032 14.7803 3.21967C14.6397 3.07902 14.4489 3 14.25 3H3.75ZM2.15901 2.15901C2.58097 1.73705 3.15326 1.5 3.75 1.5H14.25C14.8467 1.5 15.419 1.73705 15.841 2.15901C16.263 2.58097 16.5 3.15326 16.5 3.75V11.25C16.5 11.8467 16.263 12.419 15.841 12.841C15.419 13.2629 14.8467 13.5 14.25 13.5H5.56066L2.78033 16.2803C2.56583 16.4948 2.24324 16.559 1.96299 16.4429C1.68273 16.3268 1.5 16.0533 1.5 15.75V3.75C1.5 3.15326 1.73705 2.58097 2.15901 2.15901Z"></path>
                    </svg>
                  </a>
                  <a href="javascript:void(0)" class="text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M9 7.5C8.17157 7.5 7.5 8.17157 7.5 9C7.5 9.82843 8.17157 10.5 9 10.5C9.82843 10.5 10.5 9.82843 10.5 9C10.5 8.17157 9.82843 7.5 9 7.5ZM6 9C6 7.34315 7.34315 6 9 6C10.6569 6 12 7.34315 12 9C12 10.6569 10.6569 12 9 12C7.34315 12 6 10.6569 6 9Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M9 1.5C8.80109 1.5 8.61032 1.57902 8.46967 1.71967C8.32902 1.86032 8.25 2.05109 8.25 2.25V2.38049C8.24845 2.7681 8.1336 3.14679 7.91958 3.46996C7.70556 3.79313 7.40172 4.04666 7.04545 4.19935C6.98203 4.22653 6.91531 4.24477 6.84721 4.25367C6.52348 4.36704 6.17499 4.39498 5.83575 4.33347C5.445 4.26262 5.08444 4.07634 4.80055 3.79865L4.79464 3.79286L4.74967 3.74783C4.68002 3.6781 4.597 3.62248 4.50596 3.58474C4.41491 3.547 4.31731 3.52757 4.21875 3.52757C4.12019 3.52757 4.02259 3.547 3.93154 3.58474C3.8405 3.62248 3.75778 3.6778 3.68813 3.74754L3.68754 3.74813C3.6178 3.81778 3.56248 3.9005 3.52474 3.99154C3.487 4.08259 3.46757 4.18019 3.46757 4.27875C3.46757 4.37731 3.487 4.47491 3.52474 4.56596C3.56248 4.657 3.6178 4.73972 3.68754 4.80937L3.73868 4.86052C4.01637 5.14441 4.20262 5.505 4.27347 5.89575C4.34291 6.27872 4.29835 6.67347 4.14559 7.03108C4.00642 7.396 3.76273 7.712 3.44479 7.93941C3.12041 8.17142 2.73374 8.30047 2.33504 8.30979L2.3175 8.31H2.25C2.05109 8.31 1.86032 8.38902 1.71967 8.52967C1.57902 8.67032 1.5 8.86109 1.5 9.06C1.5 9.25891 1.57902 9.44968 1.71967 9.59033C1.86032 9.73098 2.05109 9.81 2.25 9.81H2.38049C2.7681 9.81155 3.14679 9.9264 3.46996 10.1404C3.79201 10.3537 4.0449 10.6562 4.19776 11.0108C4.35681 11.3732 4.40408 11.7748 4.33347 12.1642C4.26262 12.555 4.07634 12.9156 3.79865 13.1994L3.79286 13.2054L3.74783 13.2503C3.6781 13.32 3.62248 13.403 3.58474 13.494C3.547 13.5851 3.52757 13.6827 3.52757 13.7812C3.52757 13.8798 3.547 13.9774 3.58474 14.0685C3.62248 14.1595 3.6778 14.2422 3.74754 14.3119L3.74813 14.3125C3.81778 14.3822 3.90049 14.4375 3.99154 14.4753C4.08259 14.513 4.18019 14.5324 4.27875 14.5324C4.37731 14.5324 4.47491 14.513 4.56596 14.4753C4.65701 14.4375 4.73972 14.3822 4.80937 14.3125L4.86052 14.2613C5.14441 13.9836 5.505 13.7974 5.89575 13.7265C6.27872 13.6571 6.67347 13.7017 7.03108 13.8544C7.39599 13.9936 7.712 14.2373 7.93941 14.5552C8.17142 14.8796 8.30047 15.2663 8.30979 15.665L8.31 15.6825V15.75C8.31 15.9489 8.38902 16.1397 8.52967 16.2803C8.67032 16.421 8.86109 16.5 9.06 16.5C9.25891 16.5 9.44968 16.421 9.59033 16.2803C9.73098 16.1397 9.81 15.9489 9.81 15.75V15.6225L9.81001 15.6195C9.81155 15.2319 9.9264 14.8532 10.1404 14.53C10.3537 14.208 10.6562 13.9551 11.0109 13.8022C11.3733 13.6432 11.7748 13.5959 12.1642 13.6665C12.555 13.7374 12.9156 13.9237 13.1994 14.2014L13.2054 14.2071L13.2503 14.2522C13.32 14.3219 13.403 14.3775 13.494 14.4153C13.5851 14.453 13.6827 14.4724 13.7812 14.4724C13.8798 14.4724 13.9774 14.453 14.0685 14.4153C14.1595 14.3775 14.2422 14.3222 14.3119 14.2525L14.3125 14.2519C14.3822 14.1822 14.4375 14.0995 14.4753 14.0085C14.513 13.9174 14.5324 13.8198 14.5324 13.7213C14.5324 13.6227 14.513 13.5251 14.4753 13.434C14.4375 13.343 14.3822 13.2603 14.3125 13.1906L14.2613 13.1395C13.9836 12.8556 13.7974 12.495 13.7265 12.1042C13.6559 11.7148 13.7032 11.3133 13.8622 10.9509C14.0151 10.5962 14.268 10.2937 14.59 10.0804C14.9132 9.8664 15.2919 9.75155 15.6795 9.75001L15.6825 9.74999L15.75 9.75C15.9489 9.75 16.1397 9.67098 16.2803 9.53033C16.421 9.38968 16.5 9.19891 16.5 9C16.5 8.80109 16.421 8.61032 16.2803 8.46967C16.1397 8.32902 15.9489 8.25 15.75 8.25H15.6225L15.6195 8.24999C15.2319 8.24845 14.8532 8.1336 14.53 7.91958C14.2069 7.70556 13.9533 7.40172 13.8006 7.04545C13.7735 6.98203 13.7552 6.91531 13.7463 6.84721C13.633 6.52348 13.605 6.17499 13.6665 5.83575C13.7374 5.445 13.9237 5.08444 14.2014 4.80055L14.2071 4.79464L14.2522 4.74967C14.3219 4.68002 14.3775 4.597 14.4153 4.50596C14.453 4.41491 14.4724 4.31731 14.4724 4.21875C14.4724 4.12019 14.453 4.02259 14.4153 3.93154C14.3775 3.8405 14.3222 3.75778 14.2525 3.68813L14.2519 3.68754C14.1822 3.6178 14.0995 3.56248 14.0085 3.52474C13.9174 3.487 13.8198 3.46757 13.7213 3.46757C13.6227 3.46757 13.5251 3.487 13.434 3.52474C13.343 3.56248 13.2603 3.6178 13.1906 3.68754L13.1395 3.73868C12.8556 4.01637 12.495 4.20262 12.1042 4.27347C11.7148 4.34408 11.3132 4.29681 10.9508 4.13776C10.5962 3.9849 10.2937 3.73201 10.0804 3.40996C9.8664 3.08679 9.75155 2.7081 9.75001 2.32049L9.75 2.3175V2.25C9.75 2.05109 9.67098 1.86032 9.53033 1.71967C9.38968 1.57902 9.19891 1.5 9 1.5ZM14.55 11.25L15.2361 11.5528C15.1968 11.6419 15.1851 11.7408 15.2025 11.8366C15.2197 11.9314 15.2645 12.019 15.3314 12.0882L15.3725 12.1294C15.3726 12.1295 15.3724 12.1293 15.3725 12.1294C15.5816 12.3383 15.7477 12.5866 15.8609 12.8596C15.9741 13.1328 16.0324 13.4256 16.0324 13.7213C16.0324 14.0169 15.9741 14.3097 15.8609 14.5829C15.7477 14.856 15.5817 15.1042 15.3725 15.3131L14.8425 14.7825L15.3731 15.3125C15.1642 15.5217 14.916 15.6877 14.6429 15.8009C14.3697 15.9141 14.0769 15.9724 13.7812 15.9724C13.4856 15.9724 13.1928 15.9141 12.9196 15.8009C12.6466 15.6877 12.3986 15.5219 12.1897 15.3128C12.1896 15.3127 12.1898 15.3129 12.1897 15.3128L12.1482 15.2714C12.079 15.2045 11.9914 15.1597 11.8966 15.1425C11.8008 15.1251 11.7019 15.1368 11.6128 15.1761L11.6055 15.1794C11.5181 15.2168 11.4435 15.279 11.391 15.3583C11.3387 15.4372 11.3106 15.5297 11.31 15.6244V15.75C11.31 16.3467 11.0729 16.919 10.651 17.341C10.229 17.7629 9.65674 18 9.06 18C8.46326 18 7.89097 17.7629 7.46901 17.341C7.04705 16.919 6.81 16.3467 6.81 15.75V15.6933C6.80644 15.5979 6.77495 15.5056 6.71936 15.4278C6.66245 15.3483 6.58292 15.2877 6.49111 15.2539C6.47628 15.2484 6.46163 15.2425 6.44718 15.2361C6.35806 15.1968 6.25921 15.1851 6.16337 15.2025C6.06856 15.2197 5.981 15.2645 5.91172 15.3314L5.87063 15.3725C5.87053 15.3726 5.87072 15.3724 5.87063 15.3725C5.66172 15.5816 5.41338 15.7477 5.14037 15.8609C4.86722 15.9741 4.57444 16.0324 4.27875 16.0324C3.98306 16.0324 3.69028 15.9741 3.41713 15.8609C3.14425 15.7478 2.89631 15.582 2.68746 15.3731C2.47827 15.1642 2.31231 14.916 2.19908 14.6429C2.08585 14.3697 2.02757 14.0769 2.02757 13.7812C2.02757 13.4856 2.08585 13.1928 2.19908 12.9196C2.31231 12.6465 2.47827 12.3983 2.68746 12.1894L2.72858 12.1483C2.79546 12.079 2.84035 11.9914 2.85754 11.8966C2.87491 11.8008 2.86318 11.7019 2.82385 11.6128L2.82061 11.6055C2.78315 11.5181 2.721 11.4435 2.64174 11.391C2.56278 11.3387 2.47031 11.3106 2.37562 11.31H2.25C1.65326 11.31 1.08097 11.0729 0.65901 10.651C0.237053 10.229 0 9.65674 0 9.06C0 8.46326 0.237053 7.89097 0.65901 7.46901C1.08097 7.04705 1.65326 6.81 2.25 6.81H2.30673C2.40213 6.80644 2.49444 6.77495 2.57216 6.71936C2.65173 6.66245 2.71233 6.58292 2.7461 6.49111C2.75155 6.47628 2.75747 6.46163 2.76385 6.44718C2.80318 6.35806 2.81491 6.25921 2.79754 6.16337C2.78035 6.06857 2.73546 5.98101 2.66857 5.91173L2.62747 5.87063C2.41827 5.66166 2.25231 5.41351 2.13908 5.14037C2.02585 4.86722 1.96757 4.57443 1.96757 4.27875C1.96757 3.98307 2.02585 3.69028 2.13908 3.41713C2.25226 3.14412 2.41811 2.89607 2.62717 2.68717C2.83607 2.47811 3.08412 2.31226 3.35713 2.19908C3.63028 2.08585 3.92307 2.02757 4.21875 2.02757C4.51443 2.02757 4.80722 2.08585 5.08037 2.19908C5.35351 2.31231 5.60166 2.47827 5.81063 2.68746L5.85173 2.72857C5.92101 2.79546 6.00857 2.84035 6.10337 2.85754C6.19921 2.87491 6.29806 2.86318 6.38718 2.82385C6.43521 2.80266 6.48519 2.78662 6.5363 2.77592C6.58859 2.74042 6.63374 2.69492 6.66896 2.64174C6.72125 2.56278 6.74941 2.47031 6.75 2.37562V2.25C6.75 1.65326 6.98705 1.08097 7.40901 0.65901C7.83097 0.237053 8.40326 0 9 0C9.59674 0 10.169 0.237053 10.591 0.65901C11.0129 1.08097 11.25 1.65326 11.25 2.25V2.31562C11.2506 2.41031 11.2787 2.50278 11.331 2.58174C11.3835 2.661 11.4581 2.72319 11.5454 2.76064L11.5528 2.76381C11.642 2.80314 11.7408 2.81491 11.8366 2.79754C11.9314 2.78035 12.019 2.73546 12.0883 2.66858L12.1294 2.62747C12.3383 2.41827 12.5865 2.25231 12.8596 2.13908C13.1328 2.02585 13.4256 1.96757 13.7213 1.96757C14.0169 1.96757 14.3097 2.02585 14.5829 2.13908C14.856 2.25231 15.1042 2.41827 15.3131 2.62747C15.522 2.83631 15.6878 3.08424 15.8009 3.35713C15.9141 3.63028 15.9724 3.92306 15.9724 4.21875C15.9724 4.51444 15.9141 4.80722 15.8009 5.08037C15.6877 5.35338 15.5219 5.60143 15.3128 5.81033C15.3127 5.81043 15.3129 5.81023 15.3128 5.81033L15.2714 5.85173C15.2045 5.92101 15.1597 6.00857 15.1425 6.10337C15.1251 6.19921 15.1368 6.29806 15.1761 6.38718C15.1973 6.43521 15.2134 6.48519 15.2241 6.5363C15.2596 6.58859 15.3051 6.63374 15.3583 6.66896C15.4372 6.72125 15.5297 6.74941 15.6244 6.75H15.75C16.3467 6.75 16.919 6.98705 17.341 7.40901C17.7629 7.83097 18 8.40326 18 9C18 9.59674 17.7629 10.169 17.341 10.591C16.919 11.0129 16.3467 11.25 15.75 11.25H15.6844C15.5897 11.2506 15.4972 11.2787 15.4183 11.331C15.339 11.3835 15.2768 11.4581 15.2394 11.5454L14.55 11.25Z"></path>
                    </svg>
                  </a>
                  <a href="javascript:void(0)" class="text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M1.09835 11.5984C1.80161 10.8951 2.75544 10.5 3.75 10.5H9.75C10.7446 10.5 11.6984 10.8951 12.4017 11.5984C13.1049 12.3016 13.5 13.2554 13.5 14.25V15.75C13.5 16.1642 13.1642 16.5 12.75 16.5C12.3358 16.5 12 16.1642 12 15.75V14.25C12 13.6533 11.7629 13.081 11.341 12.659C10.919 12.2371 10.3467 12 9.75 12H3.75C3.15326 12 2.58097 12.2371 2.15901 12.659C1.73705 13.081 1.5 13.6533 1.5 14.25V15.75C1.5 16.1642 1.16421 16.5 0.75 16.5C0.335786 16.5 0 16.1642 0 15.75V14.25C0 13.2554 0.395088 12.3016 1.09835 11.5984Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M6.75 3C5.50736 3 4.5 4.00736 4.5 5.25C4.5 6.49264 5.50736 7.5 6.75 7.5C7.99264 7.5 9 6.49264 9 5.25C9 4.00736 7.99264 3 6.75 3ZM3 5.25C3 3.17893 4.67893 1.5 6.75 1.5C8.82107 1.5 10.5 3.17893 10.5 5.25C10.5 7.32107 8.82107 9 6.75 9C4.67893 9 3 7.32107 3 5.25Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.274 11.1603C14.3776 10.7593 14.7866 10.5181 15.1877 10.6217C15.9922 10.8294 16.7049 11.2984 17.214 11.9551C17.723 12.6118 17.9996 13.4189 18.0002 14.2498L18.0002 15.7503C18.0002 16.1646 17.6644 16.5003 17.2502 16.5003C16.836 16.5003 16.5002 16.1646 16.5002 15.7503L16.5002 14.2509C16.5002 14.2508 16.5002 14.251 16.5002 14.2509C16.4998 13.7524 16.3338 13.268 16.0284 12.8741C15.723 12.4801 15.2954 12.1987 14.8127 12.074C14.4116 11.9705 14.1704 11.5614 14.274 11.1603Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2736 2.16181C11.3764 1.76054 11.7849 1.51853 12.1862 1.62127C12.9928 1.82781 13.7078 2.29693 14.2184 2.95469C14.7289 3.61245 15.0061 4.42143 15.0061 5.25409C15.0061 6.08675 14.7289 6.89572 14.2184 7.55348C13.7078 8.21124 12.9928 8.68037 12.1862 8.8869C11.7849 8.98964 11.3764 8.74763 11.2736 8.34637C11.1709 7.9451 11.4129 7.53652 11.8142 7.43377C12.2981 7.30985 12.7271 7.02838 13.0334 6.63372C13.3398 6.23907 13.5061 5.75368 13.5061 5.25409C13.5061 4.75449 13.3398 4.2691 13.0334 3.87445C12.7271 3.47979 12.2981 3.19832 11.8142 3.0744C11.4129 2.97166 11.1709 2.56308 11.2736 2.16181Z"></path>
                    </svg>
                  </a>
                  <a href="javascript:void(0)" class="text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M2.90901 1.40901C3.33097 0.987053 3.90326 0.75 4.5 0.75H10.5C10.6989 0.75 10.8897 0.829018 11.0303 0.96967L15.5303 5.46967C15.671 5.61032 15.75 5.80109 15.75 6V15C15.75 15.5967 15.5129 16.169 15.091 16.591C14.669 17.0129 14.0967 17.25 13.5 17.25H4.5C3.90326 17.25 3.33097 17.0129 2.90901 16.591C2.48705 16.169 2.25 15.5967 2.25 15V3C2.25 2.40326 2.48705 1.83097 2.90901 1.40901ZM4.5 2.25C4.30109 2.25 4.11032 2.32902 3.96967 2.46967C3.82902 2.61032 3.75 2.80109 3.75 3V15C3.75 15.1989 3.82902 15.3897 3.96967 15.5303C4.11032 15.671 4.30109 15.75 4.5 15.75H13.5C13.6989 15.75 13.8897 15.671 14.0303 15.5303C14.171 15.3897 14.25 15.1989 14.25 15V6.31066L10.1893 2.25H4.5Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.75C10.9142 0.75 11.25 1.08579 11.25 1.5V5.25H15C15.4142 5.25 15.75 5.58579 15.75 6C15.75 6.41421 15.4142 6.75 15 6.75H10.5C10.0858 6.75 9.75 6.41421 9.75 6V1.5C9.75 1.08579 10.0858 0.75 10.5 0.75Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 9.75C5.25 9.33579 5.58579 9 6 9H12C12.4142 9 12.75 9.33579 12.75 9.75C12.75 10.1642 12.4142 10.5 12 10.5H6C5.58579 10.5 5.25 10.1642 5.25 9.75Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 12.75C5.25 12.3358 5.58579 12 6 12H12C12.4142 12 12.75 12.3358 12.75 12.75C12.75 13.1642 12.4142 13.5 12 13.5H6C5.58579 13.5 5.25 13.1642 5.25 12.75Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 6.75C5.25 6.33579 5.58579 6 6 6H7.5C7.91421 6 8.25 6.33579 8.25 6.75C8.25 7.16421 7.91421 7.5 7.5 7.5H6C5.58579 7.5 5.25 7.16421 5.25 6.75Z"></path>
                    </svg>
                  </a>
                  <a href="javascript:void(0)" class="text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 4.5C1.5 4.08579 1.83579 3.75 2.25 3.75H15.75C16.1642 3.75 16.5 4.08579 16.5 4.5C16.5 4.91421 16.1642 5.25 15.75 5.25H2.25C1.83579 5.25 1.5 4.91421 1.5 4.5Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 2.25C7.30109 2.25 7.11032 2.32902 6.96967 2.46967C6.82902 2.61032 6.75 2.80109 6.75 3V3.75H11.25V3C11.25 2.80109 11.171 2.61032 11.0303 2.46967C10.8897 2.32902 10.6989 2.25 10.5 2.25H7.5ZM12.75 3.75V3C12.75 2.40326 12.5129 1.83097 12.091 1.40901C11.669 0.987053 11.0967 0.75 10.5 0.75H7.5C6.90326 0.75 6.33097 0.987053 5.90901 1.40901C5.48705 1.83097 5.25 2.40326 5.25 3V3.75H3.75C3.33579 3.75 3 4.08579 3 4.5V15C3 15.5967 3.23705 16.169 3.65901 16.591C4.08097 17.0129 4.65326 17.25 5.25 17.25H12.75C13.3467 17.25 13.919 17.0129 14.341 16.591C14.7629 16.169 15 15.5967 15 15V4.5C15 4.08579 14.6642 3.75 14.25 3.75H12.75ZM4.5 5.25V15C4.5 15.1989 4.57902 15.3897 4.71967 15.5303C4.86032 15.671 5.05109 15.75 5.25 15.75H12.75C12.9489 15.75 13.1397 15.671 13.2803 15.5303C13.421 15.3897 13.5 15.1989 13.5 15V5.25H4.5Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 7.5C7.91421 7.5 8.25 7.83579 8.25 8.25V12.75C8.25 13.1642 7.91421 13.5 7.5 13.5C7.08579 13.5 6.75 13.1642 6.75 12.75V8.25C6.75 7.83579 7.08579 7.5 7.5 7.5Z"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 7.5C10.9142 7.5 11.25 7.83579 11.25 8.25V12.75C11.25 13.1642 10.9142 13.5 10.5 13.5C10.0858 13.5 9.75 13.1642 9.75 12.75V8.25C9.75 7.83579 10.0858 7.5 10.5 7.5Z"></path>
                    </svg>
                  </a>
                </div>

                <div class="flex items-center pt-6 justify-evenly">
                  <a href="javascript:void(0)" class="text-sm font-medium text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    Privacy
                  </a>
                  <a href="javascript:void(0)" class="text-sm font-medium text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    Terms
                  </a>
                  <button class="text-sm font-medium text-body-color hover:text-primary dark:text-dark-6 dark:hover:text-primary">
                    Log out
                  </button>
                </div>
            </div>
            --}}
        </aside>
        <!-- ===== Sidebar End ===== -->
