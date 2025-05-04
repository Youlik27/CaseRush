document.querySelectorAll('.ajax-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        fetch(this.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // CSRF токен
            }
        })
            .then(res => res.text())
            .then(html => {

                document.getElementById('content').innerHTML = html;

                window.history.pushState({}, '', this.href);
            });
    });
});

window.addEventListener('popstate', function () {
    fetch(location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(res => res.text())
        .then(html => {
            document.getElementById('content').innerHTML = html;
        });
});
