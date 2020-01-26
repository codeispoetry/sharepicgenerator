import unittest, time, os
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select


class ChromeSearch(unittest.TestCase):

    def setUp(self):
        options = Options()
        options.add_argument("--no-sandbox")
        options.add_argument("--headless")

        self.driver = webdriver.Chrome('../dist/api/chromedriver', chrome_options=options)
        print "Setup"

    #@unittest.skip("demonstrating skipping")
    def test_1_download(self):
        driver = self.driver
        driver.get('http://127.0.0.1/create.php')
        self.assertIn("Sharepicgenerator", driver.title)

        textEl = driver.find_element_by_id('text')
        textEl.send_keys(Keys.CONTROL, 'a')
        textEl.send_keys( 'Hallo Welt' )


        javaScript = "$('#textsize').val(300); $('#textX').val(-100); $('#textY').val(2000); text.draw(); text.bounce();"
        #driver.execute_script(javaScript)
        time.sleep(1)

        print "Download"
        download = driver.find_element_by_id('download')
        download.click()

        time.sleep(10) # wait for the image to be processed
        print "Slept 10"

    def test_2_compare(self):
        print "Compare"
        stream = os.popen('compare -metric PSNR hallo-welt.jpg pattern.jpg diff.jpg 2>&1')
        output = stream.read()
        self.assertEqual("inf", output)
        


    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()