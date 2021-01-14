## POUR arrêter ne tapez rien, ou tapez "n" ou "no" ou "non"
#IMPORT
from keras.models import load_model
import time
from keras.preprocessing import text
import os


def predict(modelPath, maxWord):

    # Chargement du modele
    print("\nChargement du modèle...")
    model = load_model(modelPath)

    while True :
        os.system('cls')
        # Recuperer le texte à tester
        inputText = input("Entrez votre texte : ")
        if inputText in ["", "n","no","non"]:
            return

        start = time.time()

        print("Tokenization du texte...")
        # Transforme le text vers une matrice de mot et permet de lui donner un indice
        tokenize = text.Tokenizer(num_words=maxWord, char_level=False)
        tokenize.fit_on_texts(inputText)
        word = tokenize.texts_to_matrix(inputText)

        print("Prediction du texte...")
        prediction = model.predict(word)[0]
        #predictionWithLabel = text_labels[np.argmax(prediction)]
        end = time.time()
        #print("\nProbabilites (temps : {0:.2f}secs)".format(end-start))
        if (prediction[0]>0.5):
            #print("\t- Non harcelement : {0:.2f}%".format(prediction[0]*100.))
            print(">Non harcelement",prediction[0]*100)
        else:
            #print("\t- Harcelement : {0:.2f}%".format(prediction[1]*100.))
            print(">Harcelement",prediction[1]*100)
    return






if __name__ == "__main__":
    """
    # MAIN
    """
    modelPath = '.\\modelTrained\\model.hdf5'
    maxWord = 10000

    predict(modelPath, maxWord)