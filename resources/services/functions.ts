export function validateFields(fields: HTMLInputElement[]): boolean {
  return fields.every((f) => f.value.trim() !== "");
}
export function getErrorMessage(error: unknown): string {
  if (error instanceof Error) return error.message;
  return "Error inesperado";
}

export function actionsEvents(
  editFn: (id: string) => void,
  deleteFn: (id: string) => void,
  restoreFn: (id: string) => void,
  setID: (id: string) => void
) {
  document.body.addEventListener("click", (e) => {
    const target = e.target as HTMLElement; // elemento clicado
    const btn = target.closest("[data-action]") as HTMLElement;

    if (!btn) return;

    const action = btn.dataset.action;
    const id = btn.dataset.id;

    if (!id || !action) return;

    setID(id);

    const actions: Record<string, (id: string) => void> = {
      edit: editFn,
      delete: deleteFn,
      restore: restoreFn,
    };

    const handler = actions[action];
    if (handler) handler(id);
  });
}
