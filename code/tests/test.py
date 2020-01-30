#!/usr/bin/env python
# -*- coding: utf-8 -*-

import unittest, time, os,shutil
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver import ActionChains
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
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
        driver.get('http://127.0.0.1/federal')
        self.assertIn("Sharepicgenerator", driver.title)


        # select template
        driver.find_element_by_id('templateopener').click()
        driver.find_element_by_css_selector("img[src='templates/annalena.jpg']").click()
        time.sleep(1)

        select = Select(driver.find_element_by_id('sizepresets'))
        select.select_by_visible_text('Sharepic')
        time.sleep(1)

        # Insert texts
        driver.find_element_by_id('text').send_keys(Keys.CONTROL, 'a')
        driver.find_element_by_id('text').send_keys( u"Hallo [Welt]\nutf8: äöüß" )

        driver.find_element_by_id('textbefore').send_keys( u"Über der Linie" )
        driver.find_element_by_id('textafter').send_keys( u"unterhalb" )

        driver.find_element_by_id('textsamesize').click()

        driver.find_element_by_id('pintext').send_keys( u"Ich bin der Störer" )


        # move sliders
        driver.find_element_by_id("eyecatchersize").click()
        elem = driver.find_element_by_id("eyecatchersize")
        move = ActionChains(driver)
        move.click_and_hold( elem ).move_by_offset(-40, 0).release().perform()

        driver.find_element_by_id("textsize").click()
        elem = driver.find_element_by_id("textsize")
        move = ActionChains(driver)
        move.click_and_hold( elem ).move_by_offset(-40, 0).release().perform()

        elem = driver.find_element_by_id("svg-text")
        move = ActionChains(driver)
        move.click_and_hold( elem ).move_by_offset(250, -10).release().perform()


        # logo
        select = Select(driver.find_element_by_id('logoselect'))
        #select.select_by_visible_text('Banana')
        select.select_by_value('sonnenblume-big')

        #javaScript = "$('#textsize').val(300); $('#textX').val(-100); $('#textY').val(2000); text.draw(); text.bounce();"
        #driver.execute_script(javaScript)
        driver.save_screenshot("tests/screenshot.png")

        print "click download"
        download = driver.find_element_by_id('download')
        download.click()

        element = WebDriverWait(driver, 20).until(
            EC.element_to_be_clickable((By.ID, "download"))
        )
        #time.sleep(1)
        print "downloaded"

    #@unittest.skip("no comparison")
    def test_2_compare(self):
        print "Compare"
        filename = "hallo-welt-utf-facebook-sharepic.jpg"
        stream = os.popen('compare -metric PSNR tests/artifacts/' + filename +' tests/patterns/' + filename + ' tests/artifacts/' + filename + '_diff.jpg 2>&1')
        output = stream.read()
        self.assertEqual("inf", output)
        


    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()