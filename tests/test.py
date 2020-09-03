import unittest, time, os, shutil, json
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class sharepicgenerator(unittest.TestCase):

    def setUp(self):
        self.chrome_options = webdriver.ChromeOptions()
        self.chrome_options.add_argument('--window-size=1280,800')
        self.chrome_options.add_argument('--ignore-certificate-errors')
        self.chrome_options.add_argument("--incognito")

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


    def tearDown(self):
        self.driver.save_screenshot("artifacts/screenshot.png")
        for entry in self.driver.get_log('browser'):
            print(entry)
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()



