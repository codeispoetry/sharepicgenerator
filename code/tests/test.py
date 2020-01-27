import unittest, time, os,shutil
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

if os.path.isfile("tests/screenshot.png"):
    os.remove("tests/screenshot.png")

folder = 'tests/artifacts'
for filename in os.listdir(folder):
    file_path = os.path.join(folder, filename)
    try:
        if os.path.isfile(file_path) or os.path.islink(file_path):
            os.unlink(file_path)
        elif os.path.isdir(file_path):
            shutil.rmtree(file_path)
    except Exception as e:
        print('Failed to delete %s. Reason: %s' % (file_path, e))



class ChromeSearch(unittest.TestCase):

    def setUp(self):
        options = Options()
        options.add_argument("--no-sandbox")
        options.add_argument("--headless")
        prefs = {"download.default_directory" : "/var/www/html/tests/artifacts"}
        options.add_experimental_option("prefs",prefs)

        self.driver = webdriver.Chrome('/var/www/html/dist/api/chromedriver', chrome_options=options)
        self.driver.set_window_size(1400,800)

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
        driver.save_screenshot("tests/screenshot.png")

        print "Download"
        download = driver.find_element_by_id('download')
        download.click()

        time.sleep(3) # wait for the image to be processed
        print "Slept 10"

    def test_2_compare(self):
        print "Compare"
        stream = os.popen('compare -metric PSNR tests/artifacts/hallo-welt.jpg tests/assets/pattern.jpg tests/artifacts/diff.jpg 2>&1')
        output = stream.read()
        self.assertEqual("inf", output)
        


    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()