import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  const URL = process.env.URL || 'http://localhost:9000/';
  const PASS = process.env.PASS || undefined;

  if( !PASS ) {
    await expect(false, 'No password given.').toBeTruthy();
    return;
  }
  await page.goto(URL);

  await page.locator('#test-access-password').fill(PASS);
  await page.keyboard.press('Enter');

  await page.getByTitle('Hintergrundfarbe setzen').hover();
  await page.getByTitle('Hintergrundfarbe setzen').locator('span').nth(1).click();
  await page.getByPlaceholder('Suchbegriff').click();
  await page.getByPlaceholder('Suchbegriff').fill('berge');
  await page.getByRole('button', { name: 'suchen' }).click();
  await page.locator('.img-fluid').first().click();
  await page.getByRole('tab', { name: '' }).click();
  await page.getByPlaceholder('Haupttext').click();
  await page.getByPlaceholder('Haupttext').press('Enter');
  await page.getByPlaceholder('Haupttext').fill('Bereit, weil Ihr es seid.\nTest bestanden');
  await page.getByPlaceholder('Dein Text').click();
  await page.getByPlaceholder('Dein Text').fill('Störer');
  await page.getByPlaceholder('Dein Text').click();
  await page.getByRole('tabpanel', { name: '' }).getByText('größer').click({
    clickCount: 3
  });
  const downloadPromise = page.waitForEvent('download');
  await page.getByRole('button', { name: ' Herunterladen' }).click();
  const download = await downloadPromise;
});