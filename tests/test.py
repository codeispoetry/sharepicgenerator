import unittest, time, os,shutil
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
        self.driver.implicitly_wait(10) # seconds


    def test_startpage(self):
        driver = self.driver
        if "URL" in os.environ:
            url = os.environ['URL']
        else:
            url = "http://webserver"

        driver.get( url )

        self.assertIn("Sharepicgenerator", driver.title)

        #elem = driver.find_element_by_name("q")
        #elem.send_keys("pycon")
        #elem.send_keys(Keys.RETURN)
        # assert "No results found." not in driver.page_source

        driver.save_screenshot("artifacts/screenshot.png")

        for entry in driver.get_log('browser'):
            print(entry)

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()



