## POUR arrêter ne tapez rien, ou tapez "n" ou "no" ou "non"
#IMPORT
from keras.models import load_model
import time
from keras.preprocessing import text
import os


def predict(modelPathP,modelPathN, maxWord, threshold =0.5):

    # Chargement du modele
    print("\nChargement du modèle...")
    modelH = load_model(modelPathP)
    modelNH = load_model(modelPathN)

    while True :
        os.system('cls')
        # Recuperer le texte à tester
        inputText = input("Entrez votre texte : ")
        if inputText in ["", "n","no","non"]:
            return

        start = time.time()

        print("Tokenization du texte...")
        # Transforme le text vers une matrice de mot et permet de lui donnée un indice
        tokenize = text.Tokenizer(num_words=maxWord, char_level=False)
        tokenize.fit_on_texts(inputText)
        word = tokenize.texts_to_matrix(inputText)

        print("Prediction du texte...")
        predictionH = modelH.predict(word)[0]
        predictionNH = modelNH.predict(word)[0]
        #predictionWithLabel = text_labels[np.argmax(prediction)]
        end = time.time()
        print("Confidences : Harass :",predictionH[1]*100,"% Non-Harass :",predictionNH[1]*100,"%")
        if (predictionNH[1]>threshold and predictionH[1]<(1-threshold)):
            #print("\t- Non harcelement : {0:.2f}%".format(prediction[0]*100.))
            print("    UNANIMOUS NON HARASS")
        elif (predictionH[1]>threshold and predictionNH[1]<(1-threshold)):
            #print("\t- Harcelement : {0:.2f}%".format(prediction[1]*100.))
            print("    UNANIMOUS HARASS")
        elif (predictionH[1]>threshold and predictionH[1]>predictionNH[1]):
            print("    PRETTY SURE HARASS")
        elif (predictionNH[1]>threshold and predictionNH[1]>predictionH[1]):
            print("    PRETTY SURE NON HARASS")
        elif (predictionH[1]>0.5 and predictionH[1]>predictionNH[1]):
            print("    MORE HARASS")
        elif (predictionH[1]>0.5 and predictionH[1]>predictionNH[1]):
            print("    MORE NON HARASS")
        else :
            print("    UNSURE WTF")



        #again = input("\nRecommencer ? (O/N) ")
        #if again == 'n':
        #    return



if __name__ == "__main__":
    """
    # MAIN
    """
    modelPathPositive = '.\\modelTrained\\model_H.hdf5'
    modelPathNegative = '.\\modelTrained\\model_NH.hdf5'
    maxWord = 1000

    predict(modelPathPositive,modelPathNegative, maxWord, 0.55)