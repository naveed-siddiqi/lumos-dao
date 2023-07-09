<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/@albedo-link/intent"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-freighter-api/1.1.2/index.min.js"></script>
<script>
    @if (isset($_COOKIE['wallet']))
        var wallet = "{{ $_COOKIE['wallet'] }}";
    @else
        var wallet = null;
    @endif
    var base_url = "@php echo url('/') @endphp";
    var testnet = false;
</script>
