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
        await driver.manage().window().setRect({ width: 1280, height: 1280 } );

        await driver.get( url );
        await driver.wait(until.titleIs('Sharepicgenerator'), 1000);
        await driver.findElement(By.id('test-access-password')).sendKeys(auth.password, Key.RETURN);

        let downloadEl = await driver.findElement(By.id('download'));
        let iconopener = await driver.findElement(By.id('iconopener'));

        await driver.findElement(By.id('uploadfile')).sendKeys('background.jpg');
        await driver.sleep(3000);

        await iconopener.click();
        await driver.findElement(By.id('icon-q')).sendKeys('bike',Key.RETURN);
        await driver.sleep(3000);


        await driver.findElement(By.className('chooseicon')).click();
        await driver.sleep(1000);
        await driver.wait(until.elementIsVisible(downloadEl));
        await driver.sleep(1000);

        let entries = await driver.manage().logs().get(logging.Type.BROWSER);
        entries.forEach(function(entry) {
            console.log('[%s] %s', entry.level.name, entry.message);
        });

        if( entries.length > 0 ) {
            throw  entries[0].message;
        }


        await driver.takeScreenshot().then(
            function(image, err) {
                require('fs').writeFile('screenshot.png', image, 'base64', function(err) {
                    if(err != null){
                        console.log("Screenshot",err);
                    }
                });
            }
        );
        await downloadEl.click();

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
