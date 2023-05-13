<script type='text/javascript' src="{{ asset('/assets/libs/toastify-js/src/toastify.js') }}"></script>
<script>
    var toast = window.addEventListener('alert', event => {
        Toastify({
            text: event.detail.message,
            duration: 3000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast();
    });
</script>
