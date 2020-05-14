const {Builder, By, Key, until} = require('selenium-webdriver');

(async function example() {
    let driver = await new Builder().forBrowser('chrome').build();
    try {
        await driver.get('https://sharepicgenerator.de');
        //await driver.findElement(By.name('q')).sendKeys('webdriver', Key.RETURN);
        await driver.wait(until.titleIs('Sharepicgeneratorf'), 1000);
        console.log("passed");
    } catch(e){
        throw "Test failed";
    } finally {
        await driver.quit();
    }
})();