# -*- coding: utf-8 -*-
"""
Created on Fri Dec  4 10:33:11 2015

@author: emilyzhang
"""

# -*- coding: utf-8 -*-
"""
Created on Tue Nov 17 16:53:38 2015

@author: emilyzhang
"""

MIN_20 = 20*60*1000

NUM_WINS = 0.0
NUM_LOSSES = 0.0

KILL_PRE_20_WIN = 0.0
ASSIST_PRE_20_WIN = 0.0
DEATH_PRE_20_WIN  = 0.0
TOTAL_CS_WIN = 0.0
WARDS_PLACED_WIN = 0.0

KILL_PRE_20_LOSS = 0.0
ASSIST_PRE_20_LOSS = 0.0
DEATH_PRE_20_LOSS = 0.0
TOTAL_CS_LOSS = 0.0
WARDS_PLACED_LOSS = 0.0

KILL_POST_20_WIN = 0.0
ASSIST_POST_20_WIN = 0.0
DEATH_POST_20_WIN = 0.0
TOTAL_CC_WIN = 0.0

KILL_POST_20_LOSS = 0.0
ASSIST_POST_20_LOSS = 0.0
DEATH_POST_20_LOSS = 0.0
TOTAL_CC_LOSS = 0.0   

champ_dict = { "266":"Aatrox","412":"Thresh","23":"Tryndamere","79":"Gragas","69":"Cassiopeia","13":"Ryze",
    "78":"Poppy","14":"Sion", "1":"Annie","111":"Nautilus","43":"Karma","99":"Lux","103":"Ahri","2":"Olaf",
    "112":"Viktor","34":"Anivia","86":"Garen","27":"Singed","127":"Lissandra","57":"Maokai","25":"Morgana",
    "28":"Evelynn","105":"Fizz","74":"Heimerdinger","238":"Zed","68":"Rumble","37":"Sona","82":"Mordekaiser",
    "96":"KogMaw","55":"Katarina","117":"Lulu","22":"Ashe","30":"karthus","12":"Alistar","122":"Darius","67":"Vayne",
    "77":"Udyr","110":"Varus","89":"Leona","126":"Jayce","134":"Syndra","80":"Pantheon","92":"Riven","121":"Khazix",
    "42":"Corki","51":"Caitlyn","268":"Azir","76":"Nidalee","3":"Galio","85":"Kennen","45":"Veigar","432":"Bard",
    "150":"Gnar","104":"Graves","90":"Malzahar","254":"Vi","10":"Kayle","39":"Irelia","64":"LeeSin","60":"Elise",
    "420":"Illaoi","106":"Volibear","20":"Nunu","4":"TwistedFate","24":"Jax","102":"Shyvana","429":"Kalista",
    "36":"DrMundo","223":"TahmKench","63":"Brand","131":"Diana","113":"Sejuani","8":"Vladimir","154":"Zac","421":"Reksai",
    "133":"Quinn","84":"Akali","18":"Tristana","120":"Hecarim","15":"Sivir","236":"Lucian","107":"Rengar","19":"Warwick",
    "72":"Skarner","54":"Malphite","157":"Yasuo","101":"Xerath","17":"Teemo","75":"Nasus","58":"Renekton","119":"Draven",
    "35":"Shaco","50":"Swain","115":"Ziggs","91":"Talon","40":"Janna","245":"Ekko","61":"Orianna","114":"Fiora","9":"FiddleSticks",
    "33":"Rammus","31":"Chogath","7":"Leblanc","16":"Soraka","26":"Zilean","56":"Nocturne","222":"Jinx","83":"Yorick",
    "6":"Urgot","203":"Kindred","21":"MissFortune","62":"MonkeyKing","53":"Blitzcrank","98":"Shen","201":"Braum","5":"XinZhao",
    "29":"Twitch","11":"MasterYi","44":"Taric","32":"Amumu","41":"Gangplank","48":"Trundle","38":"Kassadin","161":"Velkoz",
    "143":"Zyra","267":"Nami","59":"JarvanIV","81":"Ezreal", "202": "Jhin"}          
             

