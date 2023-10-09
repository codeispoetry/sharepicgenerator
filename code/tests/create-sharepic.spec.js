import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  const URL = process.env.URL || 'http://localhost:9000/';
  const PASS = process.env.PASS || 'secret';

  await page.goto(URL);

  await page.locator('#test-access-password').fill(PASS);
  await page.keyboard.press('Enter');


  // Image-Tab
  await page.getByText('Bild hochladen', { exact: true }).click();
  await page.locator('#uploadfile').setInputFiles('tests/assets/sunflower.jpg');
  // await page.getByPlaceholder('Bildnachweise').click();
  // await page.getByPlaceholder('Bildnachweise').fill('Urheber:');

  await page.locator('#sizepresets').selectOption('500:500');

  // Text-Tab
  await page.locator('#v-pills-profile-tab').click();
  await page.locator('#colorSetPicker0').hover();
  await page.locator('#colorSetPicker0').getByTitle('sand/tanne').click();
  await page.locator('#text').click();
  await page.locator('#text').fill('Hallo\nWelt!');

  // Logo
  await page.locator('#logofile').selectOption('/assets/de/logo-grashalm.svg');

  // Eyecatcher
  await page.locator('#pintext').fill('1. August\n2025');
  await page.locator('#pinLineSize1').selectOption('300');

  // Screenshot
  await expect(page).toHaveScreenshot();
  
  // Download
  const downloadPromise = page.waitForEvent('download');
  await page.locator('#download').click();
  const download = await downloadPromise;
  await download.saveAs('tests/results/' + download.suggestedFilename());

});