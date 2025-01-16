export const uiStore = reactive({
  isSidebarActive: false,

  toggleSidebarState(): void {
    this.isSidebarActive = !this.isSidebarActive
  }
})
