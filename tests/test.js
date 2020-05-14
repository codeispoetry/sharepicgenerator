/*
run locally with
SELENIUM_REMOTE_URL="http://localhost:4444/wd/hub" node test.js
 */

const {Builder, By, Key, until} = require('selenium-webdriver');

(async function example() {
    let driver = await new Builder().forBrowser('firefox').build();
    try {
        await driver.get('https://sharepicgenerator.de');
        //await driver.findElement(By.name('q')).sendKeys('webdriver', Key.RETURN);
        await driver.wait(until.titleIs('Sharepicgenerator'), 1000);
        console.log("passed");
    } catch(e){
        console.error("Failure");
    } finally {
        await driver.quit();
    }
})();