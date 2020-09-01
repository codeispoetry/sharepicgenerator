var auth = require('./auth.json');

const {Builder, By, Key, until} = require('selenium-webdriver');
const remote = require('selenium-webdriver/remote');
const logging = require('selenium-webdriver/lib/logging');
const chrome = require('selenium-webdriver/chrome');
let chrome_options = new chrome.Options().addArguments("incognito ");

let url = "http://webserver";
if(process.env.URL) {
    url = process.env.URL;
}

(async function example() {
    let driver = await new Builder()
        .forBrowser('chrome')
        .setChromeOptions( chrome_options )
        .build();
    try {
        driver.setFileDetector(new remote.FileDetector);
        await driver.get( url );
        await driver.wait(until.titleIs('Sharepicgenerator'), 1000);
        await driver.findElement(By.id('test-access-password')).sendKeys(auth.password, Key.RETURN);

        await driver.findElement(By.id('uploadfile')).sendKeys('background.jpg');

        let downloadEl = await driver.findElement(By.id('download'));
        await driver.wait(until.elementIsVisible(downloadEl));

        let entries = await driver.manage().logs().get(logging.Type.BROWSER);
        entries.forEach(function(entry) {
            console.log('[%s] %s', entry.level.name, entry.message);
        });

        if( entries.length > 0 ) {
            throw  entries[0].message;
        }


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