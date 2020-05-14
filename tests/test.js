var auth = require('./auth.json');


const {Builder, By, Key, until} = require('selenium-webdriver');

(async function example() {
    let driver = await new Builder().forBrowser('chrome').build();
    try {
        await driver.get('https://sharepicgenerator.de');
        await driver.wait(until.titleIs('Sharepicgenerator'), 1000);
        await driver.findElement(By.id('test-access-password')).sendKeys(auth.password, Key.RETURN);
        await driver.findElement(By.id('download')).click();
        console.log("passed");
    } catch( error ){
        const core = require('@actions/core');
        core.setFailed(error.message);
    } finally {
        await driver.quit();
    }
})();