<div
    x-data="{
        timeout: {{ $timeout }},
        warningBefore: {{ $warningBefore }},
        remaining: {{ $timeout }},
        showWarning: false,
        timer: null,

		init() {
			this.reset();
			const ping = Alpine.debounce(() => {
				this.reset();
				$wire.keepAlive(); // odświeża sesję na serwerze
			}, 1000); // max raz na 5 sekund

			['keydown', 'mousedown', 'touchstart', 'scroll', 'click'].forEach(event => {
				window.addEventListener(event, ping, { passive: true });
			});
		},

        reset() {
            this.remaining = this.timeout;
            this.showWarning = false;
            clearInterval(this.timer);
            this.start();
        },

        start() {
            this.timer = setInterval(() => {
                this.remaining--;

                if (this.remaining <= this.warningBefore) {
                    this.showWarning = true;
                }

                if (this.remaining <= 0) {
                    clearInterval(this.timer);
                    $wire.logout();
                }
            }, 1000);
        },

        formatTime(seconds) {
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            return `${m}:${s}`;
        }
    }"
>
    <!-- Warning modal -->
    <div
        x-show="showWarning"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full text-center space-y-4">
            <div class="text-4xl">⏱️</div>
            <h2 class="text-xl font-semibold text-gray-800">Brak aktywności</h2>
            <p class="text-gray-500 text-sm">
                Zostaniesz wylogowany za
            </p>
            <p class="text-4xl font-mono font-bold text-red-500" x-text="formatTime(remaining)"></p>
            <button
                @click="reset()"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition"
            >
                Pozostań zalogowany
            </button>
        </div>
    </div>

	<div
		x-show="!showWarning"
		class="fixed bottom-4 right-4 z-40 flex items-center gap-1.5 bg-gray-100 text-gray-400 text-xs px-2.5 py-1.5 rounded-full shadow-sm"
	>
		<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
		</svg>
		<span x-text="formatTime(remaining)"></span>
	</div>

	<div
		x-show="remaining <= 300 && !showWarning"
		x-transition
		class="fixed bottom-4 right-4 z-40 flex items-center gap-1.5 bg-amber-50 text-amber-500 text-xs px-2.5 py-1.5 rounded-full shadow-sm border border-amber-200"
	>
		<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
		</svg>
		<span x-text="formatTime(remaining)"></span>
	</div>
</div>
