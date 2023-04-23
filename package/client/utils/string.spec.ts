import { describe, expect, it } from 'vitest'
import { replaceRouteParams } from '.'

describe('string utils', () => {
  it('replaceRouteParams', () => {
    const path = replaceRouteParams('{foo}/:bar/baz', { foo: 'hello', bar: 'world' })

    expect(path).toBe('hello/world/baz')
  })
})
