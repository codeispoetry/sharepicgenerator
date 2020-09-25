import unittest, time, os, shutil, json
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By


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

        # Upload picture
        driver.find_element_by_id("uploadfile").send_keys(os.getcwd()+"/assets/background.jpg")
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "download")))
        time.sleep( 3 )

        # Download Sharepic
        driver.find_element_by_id("download").click()
        time.sleep( 5 )

    def tearDown(self):
        jsErrors = 0
        self.driver.save_screenshot("artifacts/screenshot.png")
        for entry in self.driver.get_log('browser'):
            if entry['level'] == 'SEVERE':
                jsErrors += 1
                print( entry['level'] )

        self.driver.quit()

        if( jsErrors > 0 ):
            self.fail( str(jsErrors)  + " JavaScript error(s)")

if __name__ == "__main__":
    if "LOCAL" in os.environ:
        unittest.main(warnings='ignore')
    else:
        unittest.main()

