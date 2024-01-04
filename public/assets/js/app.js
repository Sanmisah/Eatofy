async function logout() {
    new window.Swal({
        icon: 'question',
        title: 'Are you sure?',
        // text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonText: 'Logout',
        padding: '2em',
        customClass: 'sweet-alerts',
    }).then((result) => {
        if (result.value) {
            document.getElementById("logout-form").submit();
        }
    });
}

