import Swal from "sweetalert2";
class MyAlert {
  static alertSuccess(msg: string) {
    Swal.fire({ icon: "success", title: msg });
  }

  static alertError(msg: string) {
    Swal.fire({ icon: "error", title: msg });
  }

  static alertWarning(msg: string) {
    Swal.fire({ icon: "warning", title: msg });
  }

  static alertWarningDialog(
    question: string,
    text: string,
    confirmBtn: string,
    callback: () => void
  ) {
    Swal.fire({
      title: question,
      text: text ? text : undefined,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: confirmBtn,
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        callback();
      }
    });
  }
}

export default MyAlert;
