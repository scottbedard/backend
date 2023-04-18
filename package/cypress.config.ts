import { defineConfig } from 'cypress'

export default defineConfig({
  chromeWebSecurity: false,
  e2e: {
    baseUrl: 'http://127.0.0.1',
    specPattern: 'cypress/integration/**/*.cy.{js,jsx,ts,tsx}',
    supportFile: 'cypress/support/index.ts',
  },
  fixturesFolder: 'cypress/fixture',
  retries: 2,
  screenshotsFolder: 'cypress/screenshots',
  video: false,
  videosFolder: 'cypress/videos',
  viewportWidth: 1200,
  watchForFileChanges: false,
})
