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

        # Startpage
        driver.get( url )
        self.assertIn("Sharepicgenerator", driver.title)

        # Login
        with open('auth.json') as auth_json:
            auth = json.load(auth_json)
        driver.find_element_by_id("test-access-password").send_keys(auth['password'] + u'\ue007')

        # Test tenants
        driver.get( url + '/tenants/' + os.environ['TENANT']);
        time.sleep( 2 )
        driver.find_element_by_id("text").send_keys(Keys.CONTROL, "a")
        driver.find_element_by_id("text").send_keys("Automatischer\n[Akzeptanztest]")
        self.driver.save_screenshot("artifacts/tenant.png")
        driver.find_element_by_id("download").click()
        time.sleep( 3 )

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

