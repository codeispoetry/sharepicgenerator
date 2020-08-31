var auth = require('./auth.json');

const {Builder, By, Key, until} = require('selenium-webdriver');
const remote = require('selenium-webdriver/remote');
const logging = require('selenium-webdriver/lib/logging');

(async function example() {
    let driver = await new Builder().forBrowser('chrome').build();
    try {
        driver.setFileDetector(new remote.FileDetector);
        await driver.get('https://sharepicgenerator.de');
        await driver.wait(until.titleIs('Sharepicgenerator'), 1000);
        await driver.findElement(By.id('test-access-password')).sendKeys(auth.password, Key.RETURN);

        await driver.findElement(By.id('uploadfile')).sendKeys('background.jpg');

        let downloadEl = await driver.findElement(By.id('download'));
        await driver.wait(until.elementIsVisible(downloadEl));

        await driver.manage().logs().get(logging.Type.BROWSER)
            .then(function(entries) {

                entries.forEach(function(entry) {
                    console.log('[%s] %s', entry.level.name, entry.message);
                });

                if( entries.length > 0 ) {
                    throw  entries[0].message;
                }
            });

        console.log("passed");
    } catch( error ){
        if(process.env.ENV == 'local'){
            console.log("failed",error);
        }else {
            const core = require('@actions/core');
            core.setFailed(error.message);
        }
    } finally {
        setTimeout(() => {
            driver.quit();
        }, 100);
    }
})();

function consoleException(message) {
    this.message = message;
};