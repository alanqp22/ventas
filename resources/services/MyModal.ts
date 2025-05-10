import "bootstrap";
import { Modal } from "bootstrap";

class MyModal {
  private modal: Modal;
  private title: HTMLElement;
  private btnDone: HTMLElement;
  private frmModal: HTMLFormElement;
  private selectedID: string | null;
  constructor(
    modalHtml: HTMLElement,
    title: HTMLElement,
    btnDone: HTMLElement,
    frmModal: HTMLFormElement
  ) {
    this.modal = new Modal(modalHtml);
    this.title = title;
    this.btnDone = btnDone;
    this.frmModal = frmModal;
    this.selectedID = null;
  }

  public setSelectedID(id: string | null) {
    this.selectedID = id;
  }

  public getSelectedID(): string | null {
    return this.selectedID;
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
    const fields = element.querySelectorAll("[required]");
    fields.forEach((field) => {
      field.removeAttribute("required");
    });
  }

  public showFields(element: HTMLElement) {
    if (!element) {
      console.error("Element to show is not defined.");
      return;
    }
    element.classList.remove("d-none");
    const fields = element.querySelectorAll("input, select, textarea");
    fields.forEach((field) => field.setAttribute("required", "true"));
  }

  public show() {
    this.frmModal.reset();
    this.modal.show();
  }

  public hide() {
    this.modal.hide();
  }

  public reset() {
    this.frmModal.reset();
  }

  private currentSubmitCallback?: (e: Event) => void;

  public setSubmitAction(callback: () => void) {
    if (!this.frmModal) {
      console.error("Form element is not defined.");
      return;
    }

    if (this.currentSubmitCallback) {
      this.frmModal.removeEventListener("submit", this.currentSubmitCallback);
    }

    this.currentSubmitCallback = (e) => {
      e.preventDefault();
      callback();
    };
    this.frmModal.addEventListener("submit", this.currentSubmitCallback);
  }
}

export default MyModal;
