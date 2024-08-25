import matplotlib.pyplot as plt
import pandas as pd
import numpy as np
import xgboost as xgb
from sklearn.preprocessing import StandardScaler

# Load dataset
df = pd.read_csv('resources/python/btc_2015_2024.csv')

# Convert 'date' to datetime and sort the data by date
df['date'] = pd.to_datetime(df['date'])
df.sort_values(by='date', ascending=True, inplace=True)

# Handle missing data if any
df.ffill(inplace=True)

# Select features and target variable
features = [
    'open', 'high', 'low', 'close', 'volume',
    'rsi_7', 'rsi_14', 'cci_7', 'cci_14',
    'sma_50', 'ema_50', 'sma_100', 'ema_100',
    'macd', 'bollinger', 'TrueRange', 'atr_7', 'atr_14'
]
X = df[features]
y = df['next_day_close']

# Normalize/Standardize data
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Train an XGBoost model
model = xgb.XGBRegressor(n_estimators=100, random_state=42)
model.fit(X_scaled, y)

# Predict future prices based on the model
def predict_price(model, df_filtered):
    if df_filtered[features].tail(1).empty:
        raise ValueError("No data available for prediction")
    try:
        future_X = scaler.transform(df_filtered[features].tail(1))
        predicted_prices = model.predict(future_X)
        return predicted_prices[-1]
    except Exception as e:
        print(f"Error during prediction: {str(e)}")
        raise

def get_filtered_data(df, buy_date):
    df['date'] = pd.to_datetime(df['date'])
    df_filtered = df[df['date'] <= pd.to_datetime(buy_date)]
    return df_filtered

def plot_graph():
    df = pd.read_csv('resources/python/btc_2015_2024.csv')
    df['date'] = pd.to_datetime(df['date'])
    df.sort_values(by='date', ascending=True, inplace=True)

    # Example: Predicting the last 30 days as future prices
    recent_df = df.tail(30)
    future_X = scaler.transform(recent_df[features])
    predicted_prices = model.predict(future_X)

    plt.figure(figsize=(100, 100))  # Set the size of the plot
    plt.plot(df['date'], df['close'], label='Historical Price')
    plt.plot(recent_df['date'], predicted_prices, label='Predicted Price', linestyle='--')

    plt.xlabel('Date')
    plt.ylabel('Price')
    plt.title('Historical and Predicted Bitcoin Prices')
    plt.legend()
    plt.grid(True)
    
    plt.savefig('resources/python/historical_and_predicted.png')
    plt.close()

if __name__ == '__main__':
    plot_graph()
