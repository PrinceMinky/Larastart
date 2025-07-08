function scrollContainer() {
    return {
        el: null,
        isDown: false,
        startX: 0,
        scrollLeft: 0,

        init() {
            this.el = this.$el;

            this.onMouseUp = () => {
                this.isDown = false;
                this.el.classList.remove('cursor-grabbing');
                document.body.classList.remove('user-select-none');
            };

            this.onMouseDown = (e) => {
                const target = e.target;

                if (
                    target.closest('[draggable]') ||
                    ['INPUT', 'TEXTAREA', 'BUTTON', 'SELECT', 'A'].includes(target.tagName)
                ) return;

                this.isDown = true;
                this.startX = e.pageX - this.el.offsetLeft;
                this.scrollLeft = this.el.scrollLeft;
                this.el.classList.add('cursor-grabbing');
                document.body.classList.add('user-select-none');
            };

            this.onMouseMove = (e) => {
                if (!this.isDown) return;
                e.preventDefault();
                const x = e.pageX - this.el.offsetLeft;
                const walk = (x - this.startX) * 1.5;
                this.el.scrollLeft = this.scrollLeft - walk;
            };

            this.onTouchStart = (e) => {
                this.isDown = true;
                this.startX = e.touches[0].pageX - this.el.offsetLeft;
                this.scrollLeft = this.el.scrollLeft;
                document.body.classList.add('user-select-none');
            };

            this.onTouchMove = (e) => {
                if (!this.isDown) return;
                e.preventDefault();
                const x = e.touches[0].pageX - this.el.offsetLeft;
                const walk = (x - this.startX) * 1.5;
                this.el.scrollLeft = this.scrollLeft - walk;
            };

            this.onTouchEnd = () => {
                this.isDown = false;
                this.el.classList.remove('cursor-grabbing');
                document.body.classList.remove('user-select-none');
            };

            this.el.addEventListener('mousedown', this.onMouseDown);
            window.addEventListener('mouseup', this.onMouseUp);
            this.el.addEventListener('mouseleave', this.onMouseUp);
            this.el.addEventListener('mousemove', this.onMouseMove);

            this.el.addEventListener('touchstart', this.onTouchStart, { passive: false });
            this.el.addEventListener('touchmove', this.onTouchMove, { passive: false });
            this.el.addEventListener('touchend', this.onTouchEnd);
        },

        destroy() {
            this.el.removeEventListener('mousedown', this.onMouseDown);
            window.removeEventListener('mouseup', this.onMouseUp);
            this.el.removeEventListener('mouseleave', this.onMouseUp);
            this.el.removeEventListener('mousemove', this.onMouseMove);

            this.el.removeEventListener('touchstart', this.onTouchStart);
            this.el.removeEventListener('touchmove', this.onTouchMove);
            this.el.removeEventListener('touchend', this.onTouchEnd);
        },
    }
}

window.scrollContainer = scrollContainer;