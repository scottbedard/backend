/**
 * Replace route params with keys of an object
 */
export function replaceRouteParams(path: string, obj: Record<string, any>) {
  const replace = (val: string, key: string) => obj[key] ?? val

  return path
    .replaceAll(/\:(\w+)/g, replace)
    .replaceAll(/\{(\w+)\}/g, replace)
}
