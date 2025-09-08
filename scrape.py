import requests
from bs4 import BeautifulSoup
import json
import time

def scrape_skyscraper_data():
    base_url = "https://www.skyscrapercenter.com/buildings"
    
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language': 'en-US,en;q=0.5',
        'Connection': 'keep-alive',
        'Upgrade-Insecure-Requests': '1',
        'Cache-Control': 'max-age=0'
    }
    
    try:
        # Make the request to the website
        print(f"Fetching data from: {base_url}")
        response = requests.get(base_url, headers=headers, timeout=30)
        response.raise_for_status()
        content = response.text
        
        # Save the HTML content for debugging
        with open('debug_response.html', 'w', encoding='utf-8') as f:
            f.write(content)
        
        # Parse the HTML content
        soup = BeautifulSoup(content, 'html.parser')
        
        # Find the table containing the building data
        table = soup.find('table', {'id': 'buildingsTable'})
        
        if not table:
            print("Table not found on the page")
            return []
        
        # Extract table rows
        buildings_data = []
        tbody = table.find('tbody')
        
        if tbody:
            rows = tbody.find_all('tr')
            
            for row in rows:
                try:
                    # Get all cells
                    cells = row.find_all('td')
                    
                    if len(cells) >= 9:  # Ensure we have all needed cells
                        def clean_text(element):
                            """Clean text by removing newlines and extra spaces"""
                            if element:
                                return ' '.join(element.get_text().replace('\n', ' ').split())
                            return ''

                        # Extract and clean all fields
                        rank = clean_text(cells[0].find('p'))
                        name = clean_text(cells[1].find('a'))
                        city = clean_text(cells[2].find('a'))
                        status = cells[3].get('data-order', '')
                        completion = clean_text(cells[4].find('p'))
                        height = clean_text(cells[5].find('p', {'class': 'whitespace-no-wrap'}))
                        floors = clean_text(cells[6].find('p'))
                        material = clean_text(cells[7].find('p'))
                        function = clean_text(cells[8].find('p'))
                        
                        # Convert data types
                        try:
                            rank = int(rank)
                        except ValueError:
                            rank = 0
                            
                        try:
                            completion = int(completion)
                        except ValueError:
                            completion = 0
                            
                        try:
                            floors = int(floors)
                        except ValueError:
                            floors = 0
                            
                        # Clean up height string (remove extra whitespace)
                        height = ' '.join(height.split())
                        
                        building_data = {
                            "#": rank,
                            "Building Name": name,
                            "City": city,
                            "Status": status,
                            "Completion": completion,
                            "Height": height,
                            "Floors": floors,
                            "Material": material.strip(),
                            "Function": function.strip()
                        }
                        buildings_data.append(building_data)
                except (AttributeError, ValueError) as e:
                    print(f"Error processing row: {e}")
                    continue
        
        # Return only the first 100 buildings
        return buildings_data[:100]
        
    except Exception as e:
        print(f"Error parsing data: {e}")
        return []

def save_to_json(data, filename='skyscrapers-proposed.json'):
    """Save the scraped data to a JSON file"""
    try:
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
        print(f"Data successfully saved to {filename}")
    except Exception as e:
        print(f"Error saving to JSON: {e}")

# Main execution
if __name__ == "__main__":
    print("Starting web scraping...")
    
    # Scrape the data
    buildings = scrape_skyscraper_data()
    
    if buildings:
        print(f"Successfully scraped {len(buildings)} buildings")
        
        # Save to JSON file
        save_to_json(buildings)
        
        # Print first few items as sample
        print("\nSample data (first 3 buildings):")
        for i, building in enumerate(buildings[:3]):
            print(f"\nBuilding {i + 1}:")
            for key, value in building.items():
                print(f"  {key}: {value}")
    else:
        print("No data was scraped")
