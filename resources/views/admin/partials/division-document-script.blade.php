<script>
  function confirmDeleteDocument(id) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    swal({
      title: "APAKAH KAMU YAKIN ?",
      text: "INGIN MENGHAPUS DOKUMEN INI!",
      icon: "warning",
      buttons: ['TIDAK', 'YA'],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (!isConfirm) return;

      jQuery.ajax({
        url: '{{ url('/admin/document') }}/' + id,
        type: 'DELETE',
        data: { _token: token },
        success: function (response) {
          if (response.status === "success") {
            swal({
              title: 'BERHASIL!',
              text: 'DOKUMEN BERHASIL DIHAPUS!',
              icon: 'success',
              timer: 1000,
              buttons: false,
            }).then(function () {
              location.reload();
            });
          } else {
            swal({
              title: 'GAGAL!',
              text: 'DOKUMEN GAGAL DIHAPUS!',
              icon: 'error',
              timer: 1500,
              buttons: false,
            });
          }
        },
        error: function () {
          swal({
            title: 'ERROR!',
            text: 'Terjadi kesalahan pada server.',
            icon: 'error',
            timer: 1500,
            buttons: false,
          });
        }
      });
    });
  }
</script>
