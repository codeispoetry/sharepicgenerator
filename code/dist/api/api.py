#!/usr/bin/env python
import time, sys, getopt
import os, shutil
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import Select


dir = os.path.dirname(os.path.realpath(__file__))


#####################################
# get args from commandline
#####################################
fullCmdArguments = sys.argv
argumentList = fullCmdArguments[1:]
unixOptions = "ht:v"
gnuOptions = ["help", "text=", "verbose"]
try:
    arguments, values = getopt.getopt(argumentList, unixOptions, gnuOptions)
except getopt.error as err:
    print (str(err))
    sys.exit(2)

#default values
text="Tom"


for currentArgument, currentValue in arguments:
    if currentArgument in ("-v", "--verbose"):
        print ("enabling verbose mode")
    elif currentArgument in ("-h", "--help"):
        print ("displaying help")
    elif currentArgument in ("-t", "--text"):
        #print (("enabling special output mode (%s)") % (currentValue))
        text = currentValue


options = Options()
options.add_argument("--no-sandbox")
options.add_argument("--headless")

driver = webdriver.Chrome(dir + '/chromedriver', chrome_options=options)
driver.get('http://127.0.0.1/bayern')
print "connected ..."

textEl = driver.find_element_by_id('text')
textEl.send_keys(Keys.CONTROL, 'a')
textEl.send_keys( text )


driver.find_element_by_id("uploadfile").send_keys( dir + "/picture.jpg")
time.sleep(5)
print "uploaded ..."

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