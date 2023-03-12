import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  const URL = process.env.URL || 'http://localhost:9000/btw21';
  const PASS = process.env.PASS || undefined;

  await page.goto(URL);
  await page.locator('#v-pills-messages-tab').click();

  for(let i = 1; i <=3; i++) {
    await page.locator('#uploadaddpic' + i).setInputFiles('tests/assets/sunflower.jpg');
    await page.locator('#addpicrounded' + i).click();
    await page.locator('#addpicroundedborder' + i).click();

    await page.locator('#addpic' + i).hover();
    await page.mouse.down();
    await page.mouse.move(650 + i * 80, 80 + i * 50); // relative to viewport
    await page.mouse.up();
  }

  for(let i = 2; i <=3; i++) {
    await page.locator('#addpic-same-y-' + i).click();
    await page.locator('#addpic-same-y-' + i).click();
  }
  

  await page.screenshot({ path: 'tests/screenshot.png', fullPage: true });

});