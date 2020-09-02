import unittest
import os
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class sharepicgenerator(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Remote(
                          "http://localhost:4444/wd/hub",
                          desired_capabilities=DesiredCapabilities.CHROME)
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


    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()



