import { defineConfig } from 'cypress'
import setupNodeEvents from './tests/cypress/plugins/index'

export default defineConfig({
  chromeWebSecurity: false,
  defaultCommandTimeout: 5000,
  e2e: {
    baseUrl: process.env.GITHUB_ACTION
      ? 'http://localhost:8000'
      : 'http://localhost',
    setupNodeEvents(on, config) {
      return setupNodeEvents(on, config)
    },
    specPattern: 'tests/cypress/integration/**/*.cy.{js,jsx,ts,tsx}',
    supportFile: 'tests/cypress/support/index.ts',
  },
  fixturesFolder: 'tests/cypress/fixture',
  retries: 2,
  screenshotsFolder: 'tests/cypress/screenshots',
  videosFolder: 'tests/cypress/videos',
  watchForFileChanges: false,
})
