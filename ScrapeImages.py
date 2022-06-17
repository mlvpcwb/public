#Importa as dependências
import requests
from bs4 import BeautifulSoup
import urllib.request

#https://www.google.com/search?q=my+user+agent
headers = {'User-Agent': "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36"}

#URL target
url = 'https://www.google.com.br'

#Soup HTML da página
site = requests.get(url, headers=headers)
soup = BeautifulSoup(site.content, 'html.parser')

#TAG target
images = soup.find_all("img")

#Loop das imagens
index = 0

for image in images:
  #variaveis do loop
  filename = os.path.basename(image_src)
  image_src =  image["src"]  

  #Reconstroi [image_src] se URL é relativa
  if image_src.find("http")!=-0:
    image_src =  url + image["src"] 
  
  #Print das URLs no console
  print(index, image_src, filename)

  #Download das imagens
  urllib.request.urlretrieve(image_src, str(index) + "_" + filename)
  index += 1
#Fim do loop
