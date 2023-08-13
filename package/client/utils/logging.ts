export function error(text: string, ...extra: any[]) {
  console.error(`[backend] ${text}`, ...extra)
}
