#!/usr/bin/env python
# -*- coding: utf-8 -*-

import time, sys, getopt,json
import os, shutil

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import Select


dir = os.path.dirname(os.path.realpath(__file__))

#default values
text= u"zäüßö"

try:
    with open('../api/data.json') as json_file:
        data = json.load(json_file)
except:
    sys.stderr.write("no json file")
    sys.exit()

text = data['text'] 

os.system('pkill chromium')

options = Options()
options.add_argument("--no-sandbox")
options.add_argument("--headless")

driver = webdriver.Chrome(dir + '/chromedriver', chrome_options=options)
try:
    driver.get('https://127.0.0.1/bayern')
    #driver.get('http://127.0.0.1/create.php')
except:
    driver.save_screenshot("screenshot.png")
    sys.stderr.write("Could not connect. Screenshot saved.")
    sys.exit()
print "connected ..."

textEl = driver.find_element_by_id('text')
textEl.send_keys(Keys.CONTROL, 'a')
textEl.send_keys( text )

#driver.save_screenshot("screenshot.png")
#sys.exit()


try:
    driver.find_element_by_id("uploadfile").send_keys( dir + "/picture.jpg")
    time.sleep(5)
    print "uploaded ..."
except:
    print("No file to upload")



#select = Select(driver.find_element_by_id('logoselect'))
#select.select_by_visible_text('Banana')
#select.select_by_value('sonnenblume-big')
#time.sleep(1)


javaScript = "$('#textsize').val(300); $('#textX').val(-100); $('#textY').val(2000); text.draw(); text.bounce();"
driver.execute_script(javaScript)
time.sleep(1)

# for bayern only
javaScript = "$('#pinsize').val(85); $('#pinX').val(4000); $('#pinY').val(4000); pin.draw(); pin.bounce();"
driver.execute_script(javaScript)
time.sleep(1)


download = driver.find_element_by_id('download')
download.click()
print "download clicked ..."

time.sleep(20) # wait for the image to be processed
driver.quit()


filename = max([f for f in os.listdir('.')], key=os.path.getctime)
shutil.move(filename,"sharepic.png")

