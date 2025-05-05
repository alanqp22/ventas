import { Modal } from "bootstrap";
class MyModal {
  private modal: Modal;
  private title: HTMLElement;
  private btnDone: HTMLElement;
  private frmModal: HTMLFormElement;
  constructor(
    modal: Modal,
    title: HTMLElement,
    btnDone: HTMLElement,
    frmModal: HTMLFormElement
  ) {
    this.modal = modal;
    this.title = title;
    this.btnDone = btnDone;
    this.frmModal = frmModal;
  }

  public setTitle(title: string) {
    if (!this.title) {
      console.error("Title element is not defined.");
      return;
    }
    this.title.innerHTML = title;
  }

  public setBtnDone(btnDoneStr: string) {
    if (!this.btnDone) {
      console.error("Button element is not defined.");
      return;
    }
    this.btnDone.innerHTML = btnDoneStr;
  }

  public hideFields(element: HTMLElement) {
    if (!element) {
      console.error("Element to hide is not defined.");
      return;
    }
    element.classList.add("d-none");
  }

  public showFields(element: HTMLElement) {
    if (!element) {
      console.error("Element to show is not defined.");
      return;
    }
    element.classList.remove("d-none");
  }

  public show() {
    this.frmModal.reset();
    this.modal.show();
    console.log("hola desde show modal");
  }

  public hide() {
    this.modal.hide();
  }

  public reset() {
    this.frmModal.reset();
  }

  public setSubmitAction(callback: (event: Event, modal: MyModal) => void) {
    if (!this.frmModal) {
      console.error("Form element is not defined.");
      return;
    }
    this.frmModal.addEventListener("submit", (e) => {
      callback(e, this);
    });
  }
}

export default MyModal;
