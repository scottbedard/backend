const fs = require('fs')
const lucide = require('lucide')
const path = require('path')

// helper to exclude keys from the lucide import
const excludedKeys = function (key) {
  return ![
    'createElement',
    'createIcons',
    'icons',
  ].includes(key)
}

// helper to convert icon name to kebab-case
const kebab = function (str) {
  return str.replace(/([a-zA-Z])([A-Z0-9])/g, function (match, p1, p2) {
    return `${p1}-${p2.toLowerCase()}`
  }).toLowerCase()
}

// list of imports
const imports = Object.keys(lucide)
  .filter(excludedKeys)
  .map(function (key) {
    return `  ${key},`
  })

// map of icons, excluding lucide helper fns
const icons = Object.keys(lucide)
  .filter(excludedKeys)
  .map(function (key) {
    return `  '${kebab(key)}': ${key},`
  }, {})

// generate icons.ts
const output = `/**
 * Stop!
 * 
 * This is a generated file. It should be regenerated whenever
 * the lucide dependency is updated.
 *
 * https://lucide.dev/
 */

import {
${imports.join('\n')}
} from 'lucide'

/**
 * Icon map
 */
export const icons = {
${icons.join('\n')}
}

/**
 * Icon name
 */
export type IconName = keyof typeof icons
`

// write output to disk
fs.writeFileSync(path.resolve(__dirname, '../src/app/icons.ts'), output)

console.log('\x1b[32m', 'Successfully generated icons!')
console.log('\x1b[0m', `Total: ${icons.length.toLocaleString()}`)
console.log()
