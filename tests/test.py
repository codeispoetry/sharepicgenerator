import unittest, time, os, shutil, json
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains



class sharepicgenerator(unittest.TestCase):

    def setUp(self):
        prefs = {
            "download.default_directory": os.getcwd() + "/artifacts",
            "download.prompt_for_download": False,
            "download.directory_upgrade": True,
            "safebrowsing.enabled": False
        }
        self.chrome_options = webdriver.ChromeOptions()
        self.chrome_options.add_argument('--window-size=1280,1280')
        self.chrome_options.add_argument('--ignore-certificate-errors')

        self.chrome_options.add_experimental_option("prefs", prefs)

        self.driver = webdriver.Remote(
                   command_executor='http://localhost:4444/wd/hub',
                   desired_capabilities=DesiredCapabilities.CHROME,
                   options=self.chrome_options)

        self.driver.delete_all_cookies()
        self.driver.implicitly_wait(30) # seconds


    def test(self):
        driver = self.driver
        if "URL" in os.environ:
            url = os.environ['URL']
        else:
            url = "http://webserver"

        # See settings
        driver.get("chrome://settings/?search=downloads")
        time.sleep( 3 )
        driver.save_screenshot("artifacts/settings.png")

        # Startpage
        driver.get( url )
        self.assertIn("Sharepicgenerator", driver.title)

        # Login
        with open('auth.json') as auth_json:
            auth = json.load(auth_json)
        driver.find_element_by_id("test-access-password").send_keys(auth['password'] + u'\ue007')

        # enter expert mode
        driver.execute_script("$('#expertmode').bootstrapToggle('on');")

        # Upload picture
        driver.find_element_by_id("uploadfile").send_keys(os.getcwd()+"/assets/background.jpg")
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "download")))
        time.sleep( 50 )

        # Upload additional picture
        self.driver.save_screenshot("artifacts/before-add-picture-line66.png")
        driver.find_element_by_xpath("//*[@data-target='.addpictures']").click()
        driver.find_element_by_id("uploadaddpic1").send_keys(os.getcwd()+"/assets/addpic.jpg")
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "download")))
        time.sleep( 3 )
        driver.find_element_by_xpath("//*[@for='addpicrounded1'][2]").click()
        moveAddPic = ActionChains(driver)
        addPicElement = driver.find_element_by_id("addpic1")
        moveAddPic.drag_and_drop_by_offset(addPicElement,90,320).perform()

        # Change text
        driver.find_element_by_xpath("//*[@data-target='.text']").click()
        driver.find_element_by_id("text").send_keys(Keys.CONTROL, "a")
        driver.find_element_by_id("text").send_keys("Automatischer\n[Akzeptanztest]")
        #driver.find_element_by_id("textsamesize").click()
        textSizeElement =  driver.find_element_by_id("textsize")
        move = ActionChains(driver)
        move.click_and_hold(textSizeElement).move_by_offset(50, 0).release().perform()

        # Add icon
        driver.find_element_by_id("uploadicon").send_keys(os.getcwd()+"/assets/icon.svg")
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "download")))

        # Move text
        moveText = ActionChains(driver)
        textElement = driver.find_element_by_id("svg-text")
        moveText.drag_and_drop_by_offset(textElement,20,30).perform()

        # Change logo
        driver.find_element_by_xpath("//*[@data-target='.logo']").click()
        logoSelect = Select(driver.find_element_by_id('logoselect'))
        logoSelect.select_by_value('sonnenblume-weiss')

        # Eyecatcher
        driver.find_element_by_xpath("//*[@data-target='.eyecatcher']").click()
        driver.find_element_by_id("pintext").send_keys("bestanden")


        # Download Sharepic
        driver.find_element_by_id("download").click()
        time.sleep( 5 )

    def tearDown(self):
        jsErrors = 0
        self.driver.save_screenshot("artifacts/screenshot.png")
        for entry in self.driver.get_log('browser'):
            if entry['level'] == 'SEVERE':
                jsErrors += 1
                print( entry )

        self.driver.quit()

        if( jsErrors > 0 ):
            self.fail( str(jsErrors)  + " JavaScript error(s)")

if __name__ == "__main__":
    if "LOCAL" in os.environ:
        unittest.main(warnings='ignore')
    else:
        unittest.main()

