import { test, expect } from '@playwright/test';

test('create sharepic', async ({ page }) => {
  await page.goto('http://localhost:9000/btw21');
  await page.getByPlaceholder('Suchbegriff').click();
  await page.getByPlaceholder('Suchbegriff').fill('berge');
  await page.getByRole('button', { name: 'suchen' }).click();
  await page.locator('img:nth-child(3)').click();

  await page.getByRole('button', { name: 'ja nein' }).click();
  await page.getByRole('tab', { name: ' Text' }).click();
  await page.getByPlaceholder('Haupttext').click();
  await page.getByPlaceholder('Text darüber').click();
  await page.getByPlaceholder('Text darüber').fill('Hallo');

  await expect(page).toHaveScreenshot('create-sharepic.png');
});