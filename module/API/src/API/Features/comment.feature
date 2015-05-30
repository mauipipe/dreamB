Feature:
  In order to handle comments
  As a api maintainer
  I should be able to add/list comment through a REST calls

  @comment
  Scenario: add a new comment
    Given I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    And there are 0 'Comment' in the system
    And 0 saved images
    When I send a POST request to "/comment" with values:
      | beach_id    | 1                                      |
      | name        | Gandalf                                |
      | lastName    | Grey                                   |
      | description | beautiful beach carved betwen 2 cliffs |
    Then the response code should be 201
    And there are 1 'Comment' in the system

  @comment
  Scenario: display a list of comments
    Given I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    And I send a POST request to "/comment" with values:
      | beach_id    | 1                                      |
      | name        | Gandalf                                |
      | lastName    | Grey                                   |
      | description | beautiful beach carved betwen 2 cliffs |
    When I send a GET request to "/comment"
    Then the response code should be 200
    And the response should contain json:
    """
   [
    {
        "id": 1,
        "name": "Gandalf",
        "lastName": "Grey",
        "description": "beautiful beach carved betwen 2 cliffs",
        "beach": {
            "id": 1,
            "name": "Boca Raton",
            "city": "San Francisco"
        }
    }
  ]
    """