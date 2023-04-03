declare global {
  interface Window {
    createPlugin: () => void
    context: any
  }
}

export {}
