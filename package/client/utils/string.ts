/**
 * Replace route params with keys of an object
 */
export function replaceRouteParams(path: string, obj: Record<string, any>) {
  return path.replaceAll(/\:(\w+)/g, (val, key) => obj[key] ?? val)
}
