@push('scripts')
<script>
    function employeeView(initialView) {
        return {
            viewMode: initialView || 'grid',
            isLoading: false,

            setViewMode(mode) {
                if (this.viewMode !== mode) {
                    this.viewMode = mode;
                    this.updateURL(mode);
                }
            },

            updateURL(mode) {
                let url = new URL(window.location);
                url.searchParams.set('view', mode);

                window.history.replaceState({}, '', url);
            }
        }
    }
</script>
@endpush
