##HOW TO RUN : >python PATH/Predict.py 'mode:[mode]' [INPUT] (mode argument is facultative)
##POUR PHP :
#$command = escapeshellcmd('python PATH/Predict.py '  +  "la phrase");
#$output = shell_exec($command);
#
#et normalement ça fonctionne

from keras.models import load_model
from keras.preprocessing import text
import sys

#PATHS (on essaie d'être lançable indépendament de l'OS du serveur)
if sys.platform == "linux" or "linux2" :
    modelPathPositive = './modelTrained/model_H.hdf5'
    modelPathNegative = './modelTrained/model_NH.hdf5'
    modelPathDefault = './modelTrained/model.hdf5'
elif sys.platform == "win32" :
    modelPathPositive = '.\\modelTrained\\model_H.hdf5'
    modelPathNegative = '.\\modelTrained\\model_NH.hdf5'
    modelPathDefault = '.\\modelTrained\\model.hdf5'
else :
    print("Platform not recognised, using linux standarts for file paths, i.e straight slash, may create errors")
    modelPathPositive = './modelTrained/model_H.hdf5'
    modelPathNegative = './modelTrained/model_NH.hdf5'
    modelPathDefault = './modelTrained/model.hdf5'
txtStart=2

def predict(inputText, model1, model2=None,threshold=0.55):
    if model2 == None:
        tokenize = text.Tokenizer(num_words=10000, char_level=False)
        tokenize.fit_on_texts(inputText)
        word = tokenize.texts_to_matrix(inputText)
        return model1.predict(word)[0][1]>0.5
    else:
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







#ACTUAL SCRIPT

if sys.argv[1] == "mode:simple":
    modele = load_model(modelPathDefault)
    modele2 = None
elif sys.argv[1] == "mode:dual":
    modele = load_model(modelPathPositive)
    modele2 = load_model(modelPathNegative)
else :
    #no mode specified, all inputs are txt
    modele = load_model(modelPathDefault)
    modele2 = None
    txtStart-=1
    #first if is redundant, but still cleaner like this
#concatenating into one string
string=""
for word in sys.argv[txtStart:]:
    string+=word+" "
sys.exit(predict(string,modele,modele2))





