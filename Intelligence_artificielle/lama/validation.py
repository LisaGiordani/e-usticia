##Génère le graphe de comparaison pour les précisions, selon les métriques de l'article 'Detecting Offensive Language in Social Media to protect Adolescent Online Safety'

from keras.models import load_model
from keras.preprocessing import text
import matplotlib.pyplot as plt
import pandas as pd
from tqdm import tqdm
#tdqm permet d'avoir une barre de chargement et un temps estimé pour les boucles, ce qui est très utile ici étant donné qu'on ne peut pas avoir de vision pendant les itérations (sous peine de spammer lourdement la sortie (et de rallonger le temps d'exécution) mais qu'on en a pour longtemps (plusieures heures si on itère sur la totalité du dataset)

modelPathPositive = '.\\modelTrained\\model_H.hdf5'
modelPathNegative = '.\\modelTrained\\model_NH.hdf5'
modelPathDefault = '.\\modelTrained\\model.hdf5'
modele = load_model(modelPathDefault)
model1 = load_model(modelPathPositive)
model2 = load_model(modelPathNegative)
print("Models loaded")


def predict1(inputText,threshold=0.5): #fonction de prédiction avec le modèle 1
    tokenize = text.Tokenizer(num_words=10000, char_level=False)
    tokenize.fit_on_texts(inputText)
    word = tokenize.texts_to_matrix(inputText)
    return modele.predict(word)[0][1]>threshold
def predict2(inputText,threshold=0.55): #fonction de prédiction avec le modèle 2 (double)
    tokenize = text.Tokenizer(num_words=1000, char_level=False)
    tokenize.fit_on_texts(inputText)
    word = tokenize.texts_to_matrix(inputText)
    predictionNH = model2.predict(word)[0]
    predictionH = model1.predict(word)[0]
    if (predictionH[1]>threshold and predictionNH[1]<(1-threshold)):
        r=True
    elif (predictionNH[1]>threshold and predictionH[1]<(1-threshold)):
        r=False
    elif (predictionH[1]>threshold and predictionH[1]>predictionNH[1]):
        r=True
    elif (predictionNH[1]>threshold and predictionNH[1]>predictionH[1]):
        r=False
    elif (predictionH[1]>0.5 and predictionH[1]>predictionNH[1]):
        r=True
    elif (predictionH[1]>0.5 and predictionH[1]>predictionNH[1]):
        r=False
    else :
        r=False
    return r
    return 'err'

data = pd.read_csv('.\\dataset\\data.txt', sep=',', names=["text", "result"])


#TN,FP,FN,TP
modèle1 = [[0,0],[0,0]]
modèle2 = [[0,0],[0,0]]
##Changer la valeur de calculate à True pour recalculer les statistiques en prenant en compte la totalité de la base de données, utiliser la chaine de caractères "partiel" pour recalculer en prenant en compte une partie du dataset (voir plus loin)
##---------
calculate=False
##---------
if calculate:
    for i in tqdm(range(data.shape[0])):
        t=data["text"][i]
        pred1=predict1(t)
        pred2=predict2(t)
        actual=data["result"][i]
        modèle1[actual][pred1]+=1
        modèle2[actual][pred2]+=1
    modèle3 = [[24613,387],[14193,10807]] # résultats de l'algo naïf
elif calculate == "partiel":
    data=shuffle(data)
    for i in tqdm(range(data.shape[0]/100)): # on utilise 1/100 du dataset total (donc 1000 phrases) ici, avec un mélange avant pour essayer de répartir un peu mieux, mais on ne garanti pas l'équilibre (de toute façon cette méthode cherche la rapidité avant tout)
        t=data["text"][i]
        pred1=predict1(t)
        pred2=predict2(t)
        actual=data["result"][i]
        modèle1[actual][pred1]+=1
        modèle2[actual][pred2]+=1
    modèle3 = [[24613,387],[14193,10807]] # résultats de l'algo naïf
elif False: #Statistiques obtenues sur les 1000 premières phrases (sans valeur particulière, servent à rappeler que le déséquilibre du set de test entraîne un faussage des statistiques)
    modèle1 = [[5, 40], [130, 825]]
    modèle2 = [[6, 39], [71, 884]]
    modèle3 = [[24613,387],[14193,10807]] # résultats de l'algo naïf
else: # statistiques obtenues sur la base de donnée complète (environ 5h30 de test, c'est pour ça qu'elles sont stockées)
    modèle1 = [[10426, 41257], [7606, 43305]]
    modèle2 = [[4496, 47187], [4003, 46908]]
    modèle3 = [[24613,387],[14193,10807]] # résultats de l'algo naïf

print(modèle1,modèle2)
print("MODEL 1 STATS:")
prec1=modèle1[1][1]/(modèle1[0][1]+modèle1[1][1])
recall1=modèle1[1][1]/(modèle1[1][0]+modèle1[1][1])
print("    precision :",prec1," (actual positives out of predicted positives)")
print("    recall :",recall1," (predicted positives out of actual positives)")
print("    FP :",modèle1[0][1]/(modèle1[0][1]+modèle1[1][1])," (wrongly predicted positives out of predicted positives)")#WARNING this definition isn't in accordance with the mathematical standarts, but we'll keep it for consistency's sake
print("    FN :",modèle1[1][0]/(modèle1[1][0]+modèle1[1][1])," (unreported offensive proportion)")
print("    F-SCORE :",2*(prec1*recall1)/(prec1+recall1))
print("MODEL 2 STATS:")
prec2=modèle2[1][1]/(modèle2[0][1]+modèle2[1][1])
recall2=modèle2[1][1]/(modèle2[1][0]+modèle2[1][1])
print("    precision :",prec2," (actual positives out of predicted positives)")
print("    recall :",recall2," (predicted positives out of actual positives)")
print("    FP :",modèle2[0][1]/(modèle2[0][1]+modèle2[1][1])," (wrongly predicted positives out of predicted positives)")
print("    FN :",modèle2[1][0]/(modèle2[1][0]+modèle2[1][1])," (unreported offensive proportion)")
print("    F-SCORE :",2*(prec2*recall2)/(prec2+recall2))
print("MODEL 3 STATS:")
prec3=modèle3[1][1]/(modèle3[0][1]+modèle3[1][1])
recall3=modèle3[1][1]/(modèle3[1][0]+modèle3[1][1])
print("    precision :",prec3," (actual positives out of predicted positives)")
print("    recall :",recall3," (predicted positives out of actual positives)")
print("    FP :",modèle3[0][1]/(modèle3[0][1]+modèle3[1][1])," (wrongly predicted positives out of predicted positives)")
print("    FN :",modèle3[1][0]/(modèle3[1][0]+modèle3[1][1])," (unreported offensive proportion)")
print("    F-SCORE :",2*(prec3*recall3)/(prec3+recall3))

precision = [prec1, prec2, prec3]
recall = [recall1, recall2, recall3]
FP = [modèle1[0][1]/(modèle1[0][1]+modèle1[1][1]), modèle2[0][1]/(modèle2[0][1]+modèle2[1][1]), modèle3[0][1]/(modèle3[0][1]+modèle3[1][1])]
FN = [modèle1[1][0]/(modèle1[1][0]+modèle1[1][1]), modèle2[1][0]/(modèle2[1][0]+modèle2[1][1]), modèle3[1][0]/(modèle3[1][0]+modèle3[1][1])]
Fscore = [2*(prec1*recall1)/(prec1+recall1), 2*(prec2*recall2)/(prec2+recall2), 2*(prec3*recall3)/(prec3+recall3)]

fig,ax = plt.subplots()
index = [0,1.3,2.6]
index = [index[i]+0.1 for i in range(len(index))]
bar_width = 0.1

index = [index[i]+0.1 for i in range(len(index))]
plt.bar(index, precision, bar_width, color="blue", label="precision")
index = [index[i]+0.1 for i in range(len(index))]
plt.bar(index, recall, bar_width, color="red", label="recall")
index = [index[i]+0.1 for i in range(len(index))]
plt.bar(index, FP, bar_width, color="green", label="FP rate")
index = [index[i]+0.1 for i in range(len(index))]
plt.bar(index, FN, bar_width, color="purple", label="FN rate")
index = [index[i]+0.1 for i in range(len(index))]
plt.bar(index, Fscore, bar_width, color="cyan", label="F-score")

plt.xlabel("Modèle")
plt.title("Accuracies of the models")
plt.xticks([0.4,1.7,3.0], ("Simple","Dual","Naif"))
plt.legend()

plt.tight_layout()
plt.show()

plt.savefig("./Accuracies of the models (2).png")














