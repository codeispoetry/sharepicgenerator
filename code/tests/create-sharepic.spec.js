import { test, expect } from '@playwright/test';

test('create sharepic', async ({ page }) => {
  await page.goto('http://localhost:9000/btw21');
  await page.getByTitle('Bild löschen und Hintergrundfarbe setzen').hover();
  await page.getByTitle('Bild löschen und Hintergrundfarbe setzen').locator('span').nth(1).click();
  await page.getByPlaceholder('Suchbegriff').click();
  await page.getByPlaceholder('Suchbegriff').fill('berge');
  await page.getByRole('button', { name: 'suchen' }).click();
  await page.locator('img:nth-child(2)').click();
  await page.locator('#backgroundsize').click();
  await page.locator('#saturate').click();

  await page.locator('.colorpicker[data-field="#copyrightcolor"]').hover();

  await page.locator('span:nth-child(5)').first().click();
  await page.locator('#sizepresets').selectOption('1200:1200');
  
  await page.getByRole('tab', { name: '' }).click();
  await page.getByPlaceholder('Text darüber').click();
  await page.getByPlaceholder('Text darüber').fill('Drüber');
  await page.getByPlaceholder('Haupttext').click();
  await page.getByPlaceholder('Haupttext').fill('Haupttext');
  await page.getByPlaceholder('Haupttext').press('Enter');
  await page.getByPlaceholder('Haupttext').fill('Haupttext\nin zwei Zeilen');
  await page.getByPlaceholder('Text unter der Linie').click();
  await page.getByPlaceholder('Text unter der Linie').fill('unter der Linie');
  await page.getByPlaceholder('Claim').click();
  await page.getByPlaceholder('Claim').fill('Claim');
  await page.getByPlaceholder('Dein Text').click();
  await page.getByPlaceholder('Dein Text').fill('Störer');

  await page.getByRole('tab', { name: '' }).click();
  await page.getByPlaceholder('Sternchentext').click();
  await page.getByPlaceholder('Sternchentext').fill('Sternchentext');
  
  await page.getByRole('tab', { name: '' }).click();
  const downloadPromise = page.waitForEvent('download');
  
  await page.getByRole('button', { name: ' Herunterladen' }).click();
  const download = await downloadPromise;

  await expect(page).toHaveScreenshot('create-sharepic.png');
});