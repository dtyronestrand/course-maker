import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: '/home/jules/verification',
  use: {
    video: 'on',
    trace: 'on',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
});
