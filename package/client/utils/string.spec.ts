import { describe, expect, it } from 'vitest'
import { replaceRouteParams } from '.'

describe('string utils', () => {
  it('replaceRouteParams', () => {
    expect(replaceRouteParams(':foo/:bar', { foo: 'hello', bar: 'world' })).toBe('hello/world')
  })
})
