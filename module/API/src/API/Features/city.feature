Feature:
  In order to handle cities
  As a api maintainer
  I should be able to list cities through a REST calls

  @city
  Scenario: display a list of cities
    Given I have 2 'City' on my system
    When I send a GET request to "/city"
    Then the response code should be 200
    And the response should contain json:
    """
   [
    {
        "id": 1,
        "name": "San Francisco",
        "slug": "san-francisco",
        "beaches": {}
    },
    {
        "id": 2,
        "name": "Palermo",
        "slug": "palermo",
        "beaches": {}
    }
]
    """

