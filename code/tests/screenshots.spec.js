// @ts-check
const { test, expect } = require('@playwright/test');
const fs = require('fs');


test('take intro screenshot of all tenants', async ({ page }) => {
  let tenants = new Array('btw21', 'berlin','bw','einigungshilfe','nds','vorort');

  for(let tenant of tenants) {
    await page.goto(`http://localhost:9000/${tenant}/`);
    await expect(page).toHaveScreenshot(`${tenant}.png`);
  }
});
