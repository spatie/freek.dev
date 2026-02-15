<!DOCTYPE html>
<html>
<head><title>Authenticating...</title></head>
<body>
<script>
    if (window.opener) {
        window.opener.postMessage({
            type: 'github-auth',
            token: @json($token),
            commenter: {
                id: {{ $commenter->id }},
                username: @json($commenter->username),
                name: @json($commenter->name),
                avatar_url: @json($commenter->avatar_url),
                is_admin: @json($commenter->is_admin),
            },
        }, window.location.origin);
    }
    window.close();
</script>
</body>
</html>
