@props(['entertainmentId', 'inWatchlist', 'entertainmentType' => null, 'customClass' => ''])

<button id="watchlist-btn-{{ $entertainmentId }}"
        class="action-btn btn {{ $inWatchlist ? 'btn-primary' : 'btn-dark' }} {{ $customClass }}"
        data-entertainment-id="{{ $entertainmentId }}"
        data-in-watchlist="{{ $inWatchlist ? 'true' : 'false' }}"
        data-entertainment-type="{{ $entertainmentType }}"
        data-bs-toggle="tooltip" data-bs-title="{{ $inWatchlist ? 'Remove watchlist' : 'Add watchlist' }}" data-bs-placement="top">
    <i class="ph {{ $inWatchlist ? 'ph-check' : 'ph-plus' }}"></i>
</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('click', '.watch-list-btn', function (event) {
    event.preventDefault();

    var $this = $(this);
    if ($this.prop('disabled')) return;
    $this.prop('disabled', true);

    var isInWatchlist = $this.data('in-watchlist');
    var entertainmentId = $this.data('entertainment-id');
    var entertainmentType = $this.data('entertainment-type');
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

    let action = isInWatchlist == '1' ? 'delete' : 'save';
    var data = isInWatchlist == '1'
        ? { id: [entertainmentId], _token: '{{ csrf_token() }}' }
        : { entertainment_id: entertainmentId, type: entertainmentType, _token: '{{ csrf_token() }}' };

    $.ajax({
        url: action === 'save' ?  `${baseUrl}/api/save-watchlist` :  `${baseUrl}/api/delete-watchlist?is_ajax=1`,
        method: 'POST',
        data: data,
        success: function (response) {
            window.successSnackbar(response.message);
            $this.find('i').toggleClass('ph-check ph-plus');
            $this.toggleClass('btn-primary btn-dark');
            var newInWatchlist = isInWatchlist == '1' ? 'false' : 'true';
            $this.data('in-watchlist', newInWatchlist === 'true' ? 1 : 0);

            var newTooltip = newInWatchlist === 'true' ? 'Remove Watchlist' : 'Add Watchlist';
            if ($this.tooltip) {
                $this.tooltip('dispose');
                $this.attr('data-bs-title', newTooltip);
                $this.tooltip();
            }
        },
        error: function (xhr) {
            if (xhr.status === 401) {
                window.location.href = `${baseUrl}/login`;
            } else {
                alert('An error occurred. Please try again.');
                console.error(xhr);
            }
        },
        complete: function () {
            $this.prop('disabled', false);
        }
    });
});
</script>
